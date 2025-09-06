<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'airport_id' => 1, // Heathrow
            'name' => $this->faker->company(),
            'code' => $this->faker->unique()->lexify('???'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'postal_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'commission' => $this->faker->randomFloat(2, 5, 20),
        ];
    }
}
