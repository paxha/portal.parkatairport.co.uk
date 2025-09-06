<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Supplier;
use App\Models\Terminal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $terminalIds = [1, 2, 3, 4]; // Terminal 2, 3, 4, 5

        $createdAt = Carbon::instance($this->faker->dateTimeBetween('2025-01-01', 'now'));
        $departureStart = $createdAt->copy()->addDay();
        $departureEnd = $createdAt->copy()->addMonths(3);
        $departure = $this->faker->dateTimeBetween($departureStart, $departureEnd);
        $departure = Carbon::instance($departure);
        $arrivalStart = $departure->copy()->addHour();
        $arrivalEnd = $departure->copy()->addMonths(1);
        $arrival = $this->faker->dateTimeBetween($arrivalStart, $arrivalEnd);

        return [
            'airport_id' => 1, // Heathrow
            'supplier_id' => Supplier::query()->inRandomOrder()->value('id'),
            'service_id' => 1,
            'reference' => $this->faker->unique()->numerify('REF#####'),
            'status' => 'confirmed',
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'departure' => $departure,
            'arrival' => $arrival,
            'departure_terminal_id' => $this->faker->randomElement($terminalIds),
            'arrival_terminal_id' => $this->faker->randomElement($terminalIds),
            'departure_flight_number' => $this->faker->lexify('FL???'),
            'arrival_flight_number' => $this->faker->lexify('FL???'),
            'registration_number' => $this->faker->bothify('??##??'),
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'color' => $this->faker->safeColorName(),
            'passengers' => $this->faker->numberBetween(1, 7),
            'amount' => $this->faker->numberBetween(100, 1000),
            'supplier_cost' => $this->faker->numberBetween(10, 100),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
