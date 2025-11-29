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
     * Categoryモデルとのリレーションを定義
     */
    public function category()
    {
        // category_idを外部キーとして使用
        return $this->belongsTo(Category::class);
    }
}

const GENDER_MAP = [

'1' => '男性',

'2' => '女性',

'3' => 'その他',

];