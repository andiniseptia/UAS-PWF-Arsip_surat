<?php

namespace Database\Factories;

use App\Models\SuratMasuk;
use App\Models\JenisSurat;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuratMasukFactory extends Factory
{
    protected $model = SuratMasuk::class;

    public function definition(): array
    {
        return [
            'no_surat_masuk'  => 'SM-' . $this->faker->unique()->numerify('###/DEF/2025'),
            'tanggal_masuk'   => $this->faker->date(),
            'pengirim'        => $this->faker->company(),
            'file'            => 'uploads/' . $this->faker->uuid() . '.pdf',
            'jenis_surat_id'  => JenisSurat::factory(),
        ];
    }
}
