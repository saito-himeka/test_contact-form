<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\DB; // 必要に応じてDBファサードを使用

class AdminController extends Controller
{
    /**
     * FN021, FN022: お問い合わせ一覧表示と検索
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // カテゴリ一覧を取得し、ビューに渡す（FN022で使用）
        $categories = Category::all();

        // --- FN022: 検索ロジック ---

        if ($input = $request->input('search_keyword')) {
            // 検索キーワード（名前またはメールアドレス）が1つのinputに入っていると仮定
            // FN022-1.a/b: 名前検索 (last_name, first_name, フルネームでの部分一致)
            // FN022-2.a/b: メールアドレス検索 (部分一致)
            $query->where(function ($q) use ($input) {
                // last_name, first_name
                $q->where('last_name', 'LIKE', "%{$input}%")
                  ->orWhere('first_name', 'LIKE', "%{$input}%");

                // フルネーム (last_name + ' ' + first_name) での部分一致を直接DBでエミュレート
                // データベースに依存する書き方ですが、フルネーム検索を実装
                $q->orWhere(DB::raw("CONCAT(last_name, ' ', first_name)"), 'LIKE', "%{$input}%");
                
                // メールアドレス
                $q->orWhere('email', 'LIKE', "%{$input}%");
            });
        }
        
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }
        
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($date = $request->input('date')) {
            // FN022-5: 日付検索
            $query->whereDate('created_at', $date);
        }

        // --- FN021: ページネーションの適用 ---
        // リレーション先のカテゴリ名をロードしておく (N+1問題対策)
        $contacts = $query->with('category')->paginate(7)->appends($request->all());

        return view('admin', compact('contacts', 'categories'));
    }

    /**
     * FN026: お問い合わせ削除機能
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        // 削除後のリダイレクト
        return redirect()->route('admin.index')->with('status', 'お問い合わせを削除しました。');
    }

    /**
     * FN024: エクスポート機能（CSV）
     */
    public function export(Request $request)
    {
        $query = Contact::query();

        // --- 検索ロジックのコピー (共通化するのが理想ですが、簡易的に記述します) ---
        if ($keyword = $request->input('search_keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('last_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('first_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('email', 'LIKE', "%{$keyword}%");
            });
        }
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }
        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }
        // -------------------------------------------------------------

        $contacts = $query->get();

        // CSV生成
        $stream = fopen('php://temp', 'r+');
        fputcsv($stream, ['ID', '名前', 'メールアドレス', '性別', 'お問い合わせ種類', '内容']);

        foreach ($contacts as $contact) {
            fputcsv($stream, [
                $contact->id,
                $contact->last_name . ' ' . $contact->first_name,
                $contact->email,
                $contact->gender_jp, // アクセサを使用
                $contact->category->content ?? '',
                $contact->detail
            ]);
        }

        rewind($stream);
        $csv = stream_get_contents($stream);
        fclose($stream);

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="contacts.csv"');
    }
}
