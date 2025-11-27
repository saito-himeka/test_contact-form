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
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'gender' => $this->faker->numberBetween(1, 3),
            'email' => $this->faker->unique()->safeEmail,
            // 電話番号は XXX-XXXX-XXXX 形式で生成
            'tel' => $this->faker->numerify('###########'),
            'address' => $this->faker->prefecture . $this->faker->city . $this->faker->streetAddress,
            'building' => $this->faker->optional(0.5)->secondaryAddress, 
            'category_id' => $this->faker->numberBetween(1, 5), 
            'detail' => $this->faker->realText(120), 
        ];
    }
}
