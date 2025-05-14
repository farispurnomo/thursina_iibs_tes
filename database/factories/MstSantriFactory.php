<?php

namespace Database\Factories;

use App\Models\MstAsrama;
use Illuminate\Database\Eloquent\Factories\Factory;

class MstSantriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nis'           => $this->faker->numerify('############'),
            'nama'          => $this->faker->name(),
            'alamat'        => $this->faker->streetAddress(),
            'asrama_id'     => MstAsrama::all()->random()->id,
            'total_paket'   => 0
        ];
    }
}
