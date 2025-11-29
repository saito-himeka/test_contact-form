<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'category_id',
        'detail'
    ];

    /**
     * 性別コードと日本語名の対応表
     * 1:男性, 2:女性, 3:その他
     */
    public const GENDER_MAP = [
        '1' => '男性',
        '2' => '女性',
        '3' => 'その他',
    ];

    /**
     * 性別コードを日本語に変換するためのアクセサ
     * ビュー側で $contact->gender_jp と書くと、自動的にこの処理が走ります
     */
    public function getGenderJpAttribute()
    {
        // DBの値を取得
        $genderCode = $this->attributes['gender'];

        // マップに対応する値があればそれを返し、なければ'不明'を返す
        return self::GENDER_MAP[$genderCode] ?? '不明';
    }

    /**
     * Categoryモデルとのリレーションを定義
     */
    public function category()
    {
        // category_idを外部キーとして使用
        return $this->belongsTo(Category::class);
    }
}
