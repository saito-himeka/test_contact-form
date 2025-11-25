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
        
        return redirect('/thanks');
    }
}
