<?php

namespace Database\Factories;

use App\Models\SuratKeluar;
use App\Models\JenisSurat;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuratKeluarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SuratKeluar::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_surat_keluar' => 'SK-' . $this->faker->unique()->numerify('###/GHI/2025'),
            'tanggal_keluar'  => $this->faker->date(),
            'tujuan'          => $this->faker->company(),
            'file'            => 'uploads/' . $this->faker->uuid() . '.pdf',
            'jenis_surat_id'  => JenisSurat::factory(),
        ];
    }
}
