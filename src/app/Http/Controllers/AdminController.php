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
            // FN022-3: 性別検索
            if ($gender !== '全て' && $gender !== '性別') {
                $query->where('gender', $gender);
            }
        }
        
        if ($category_id = $request->input('category_id')) {
            // FN022-4: お問い合わせの種類検索（外部キー利用）
            if ($category_id !== '全て') {
                $query->where('category_id', $category_id);
            }
        }

        if ($date = $request->input('date')) {
            // FN022-5: 日付検索
            $query->whereDate('created_at', $date);
        }

        // --- FN021: ページネーションの適用 ---
        // リレーション先のカテゴリ名をロードしておく (N+1問題対策)
        $contacts = $query->with('category')->paginate(7)->appends($request->all());

        return view('admin', [
            'contacts' => $contacts,
            'categories' => $categories,
        ]);
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
        // indexメソッドと同じ検索ロジックを適用して、絞り込まれたデータを取得
        $query = Contact::query();
        
        // 検索ロジックは index メソッドからコピーし、全件取得に切り替える
        // ... (indexメソッドの検索ロジックを全てここにコピー＆ペースト) ...
        
        // indexメソッドからの検索ロジックのコピー開始
        if ($input = $request->input('search_keyword')) {
            $query->where(function ($q) use ($input) {
                $q->where('last_name', 'LIKE', "%{$input}%")
                  ->orWhere('first_name', 'LIKE', "%{$input}%");
                $q->orWhere(DB::raw("CONCAT(last_name, ' ', first_name)"), 'LIKE', "%{$input}%");
                $q->orWhere('email', 'LIKE', "%{$input}%");
            });
        }
        
        if ($gender = $request->input('gender')) {
            if ($gender !== '全て' && $gender !== '性別') {
                $query->where('gender', $gender);
            }
        }
        
        if ($category_id = $request->input('category_id')) {
            if ($category_id !== '全て') {
                $query->where('category_id', $category_id);
            }
        }

        if ($date = $request->input('date')) {
            $query->whereDate('created_at', $date);
        }
        // indexメソッドからの検索ロジックのコピー終了

        $contacts = $query->get(); // ページネーションせずに全件取得
        
        // CSVデータ生成
        $csv = $this->generateCsv($contacts);

        return response($csv, 200)
            ->header('Content-Type', 'text/csv; charset=SJIS')
            ->header('Content-Disposition', 'attachment; filename="contacts_export_' . now()->format('YmdHis') . '.csv"');
    }

    /**
     * CSV生成ヘルパー関数
     */
    private function generateCsv($contacts)
    {
        // CSVのヘッダー（FN025の項目をベースに追加）
        $headers = [
            'ID', '姓', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 
            'お問い合わせの種類', 'お問い合わせ内容', '作成日時'
        ];
        
        $output = '';
        
        // CSVファイルの文字化けを防ぐため、SJISに変換 (Windowsで開くことを想定)
        $output .= mb_convert_encoding(implode(',', $headers) . "\n", 'SJIS-win', 'UTF-8');

        foreach ($contacts as $contact) {
            $row = [
                $contact->id,
                $contact->last_name,
                $contact->first_name,
                $contact->gender,
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content ?? 'N/A', // category_idがnullの場合に備える
                // 内容の改行やカンマを削除し、SJIS変換
                str_replace(["\r", "\n", ","], "", $contact->detail),
                $contact->created_at,
            ];
            
            // 各行をSJISに変換して追加
            $output .= mb_convert_encoding(implode(',', $row) . "\n", 'SJIS-win', 'UTF-8');
        }

        return $output;
    }
}
