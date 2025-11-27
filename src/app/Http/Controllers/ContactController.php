<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index(){

        $categories = Category::all();

        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request){

        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        //フォームの値の取得
        $contact = $request->only([
        'last_name',
        'first_name',
        'gender',
        'email',
        'address',
        'building',
        'category_id',
        'detail'
        ]);

        //電話番号まわり
        $contact['tel'] = $tel;

        //category表示用の処理
        $category = Category::find($request->category_id);
        $contact['category_name'] = $category ? $category->content : '未選択';

        //gender表示用の処理
        $genders = [
        1 => '男性',
        2 => '女性',
        3 => 'その他'
        ];
        $contact['gender_name'] = $genders[$request->gender] ?? '未選択';

        return view('contact.confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail'
        ]);

        Contact::create($contact);

        return redirect('/thanks'); // ← PRG の超重要ポイント！
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}
/*
    public function index(){

        $categories = Category::all();

        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request){
        //フォームの値の取得
        $contact = $request->only([
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel1',
        'tel2',
        'tel3',
        'address',
        'building',
        'category_id',
        'detail'
        ]);

        //電話番号まわり
        $contact['tel'] = $request->tel1 . $request->tel2 . $request->tel3;

        //category表示用の処理
        $category = Category::find($request->category_id);
        $contact['category_name'] = $category ? $category->content : '未選択';

        //gender表示用の処理
        $genders = [
        1 => '男性',
        2 => '女性',
        3 => 'その他'
        ];
        $contact['gender_name'] = $genders[$request->gender] ?? '未選択';
            
        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request){
        dd($request->all());

        $contact = $request->only([
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'category_id',
        'detail'
        ]);

        Contact::create($contact);
        
        return redirect()->route('thanks');

}

}*/



/*
class ContactController extends Controller
{
    // 入力画面
    public function index()
    {
        return view('index');
    }

    // 確認画面
    public function confirm(Request $request)
    {
        $contact = $request->all();
        return view('confirm', compact('contact'));
    }

    // DB保存 → リダイレクト（PRG）
    public function store(Request $request)
    {
        // ★ 本番ではここで DB 保存します
        // Contact::create($request->all());

        return redirect('/thanks'); // ← PRG の超重要ポイント！
    }

    // 完了画面
    public function thanks()
    {
        return view('thanks');
    }
}*/
