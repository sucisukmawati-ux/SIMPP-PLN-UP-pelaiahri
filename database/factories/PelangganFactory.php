<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pelanggan' => fake()->unique()->numerify('22140########'),
            'nama' => fake()->name(),
            'unit' => '22140',
            'nomor_telepon' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'latitude' => null,
            'longitude' => null,
            'status' => 'aktif',
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn (): array => ['status' => 'nonaktif']);
    }
}
