<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountMovement;
use App\Models\Category;
use Features\AccountMovement\Data\Models\MovementType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountMovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AccountMovement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'destination_account_id' => Account::factory(),
            'category_id' => Category::factory(),
            'amount' => $this->faker->numerify('###'),
            'movement_type' => $this->faker->randomElement(MovementType::toValues()),
            'created_date' => $this->faker->date(),
            'created_time' => $this->faker->time('H:i'),
            'notes' => $this->faker->text,
        ];
    }
}
