<?php
namespace Database\Factories;

use App\Models\Envelope;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnvelopeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Envelope::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'amount' => $this->faker->numerify('###'),
            'target_amount' => $this->faker->numerify('###'),
            'target_reached' => $this->faker->boolean,
            'notes' => $this->faker->text,
        ];
    }
}
