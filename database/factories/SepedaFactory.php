<?php

namespace Database\Factories;
use App\Models\Sepeda;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SepedaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sepeda::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'jenis_id' => $this->faker->numberBetween(1, 10),
            'gps_number' => $this->faker->unique()->numberBetween(1, 100),
            'number' => $this->faker->unique()->numberBetween(1, 100),
            'color' => $this->faker->colorName,
            'pict' => 'gambar.jpg',
            // Tambahkan atribut lainnya sesuai kebutuhan Anda
        ];
    }
}

