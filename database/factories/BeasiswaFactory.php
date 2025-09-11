<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Beasiswa>
 */
class BeasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenisBeasiswa = ['prestasi', 'umum', 'tidak mampu', 'penelitian', 'hafiz'];
        $lembaga = ['Kementerian Agama RI', 'Bank Indonesia', 'Pemerintah Provinsi Kaltim', 'UINSI Samarinda', 'Djarum Foundation'];
        $nama = ['Unggulan', 'Cendekia', 'Kaltim Tuntas', 'Prestasi Akademik', 'Riset Inovatif'];
        $startYear = $this->faker->numberBetween(2023, 2025);

        return [
            'nama_beasiswa' => 'Beasiswa ' . $this->faker->randomElement($nama),
            'jenis_beasiswa' => $this->faker->randomElement($jenisBeasiswa),
            'lembaga_penyelenggara' => $this->faker->randomElement($lembaga),
            'besar_beasiswa' => $this->faker->randomElement([5000000, 7500000, 10000000, 12000000]),
            'periode' => $startYear . '/' . ($startYear + 1),
            'deskripsi' => $this->faker->paragraph(3),
        ];
    }
}
