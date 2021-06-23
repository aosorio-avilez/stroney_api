<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use App\Models\UserCurrency;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'user_currency_id' => UserCurrency::factory(),
            'name' => $this->faker->name,
            'amount' => $this->faker->numerify('###'),
            'notes' => $this->faker->text,
        ];
    }
}
