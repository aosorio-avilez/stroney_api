<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\User;
use App\Models\UserCurrency;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserCurrency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'currency_id' => Currency::factory(),
            'base_exchange_rate' => $this->faker->numerify('#####'),
            'exchange_rate' => $this->faker->numerify('#####'),
        ];
    }
}
