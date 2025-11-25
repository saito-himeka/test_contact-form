<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            // お名前（姓・名それぞれ最大8文字）
            'last_name' => $this->faker->regexify('[一-龥]{1,8}'),
            'first_name' => $this->faker->regexify('[一-龥]{1,8}'),

            // 性別
            'gender' => $this->faker->randomElement(['男性', '女性', 'その他']),

            // メールアドレス
            'email' => $this->faker->unique()->safeEmail,

            // 電話番号（半角数字5桁）
            'tel' => $this->faker->numerify('#####'),

            // 住所
            'address' => $this->faker->address,

            // 建物名（任意）
            'building' => $this->faker->optional()->company,

            // お問い合わせの種類（category_id）
            'category_id' => $this->faker->numberBetween(1, 5), // 例：1〜5のカテゴリがある場合

            // お問い合わせ内容（最大120文字）
            'detail' => $this->faker->text(120),
        ];
    }
}
