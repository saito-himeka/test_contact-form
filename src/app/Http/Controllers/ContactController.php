<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        return view('index');
    }

    public function confirm(Request $request){
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
        $categories = [
        1 => '商品のお届けについて',
        2 => '商品の交換について',
        3 => '商品トラブル',
        4 => 'ショップへのお問い合わせ',
        5 => 'その他'
        ];
        $contact['category_name'] = $categories[$request->category_id] ?? '未選択';

        //gender表示用の処理
        $genders = [
        1 => '男性',
        2 => '女性',
        3 => 'その他'
        ];
        $contact['gender_name'] = $genders[$request->gender] ?? '未選択';
            
        return view('confirm', compact('contact'));
    }

    public function store(Request $request){
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
        return view('thanks');
    }
}
