<?php

namespace Database\Factories;

use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakultasDanProdi = [
            'Fakultas Tarbiyah dan Ilmu Keguruan' => ['Pendidikan Agama Islam', 'Manajemen Pendidikan Islam', 'Pendidikan Bahasa Arab'],
            'Fakultas Syariah' => ['Hukum Keluarga Islam', 'Hukum Ekonomi Syariah'],
            'Fakultas Ushuluddin, Adab, dan Dakwah' => ['Ilmu Al-Qur\'an dan Tafsir', 'Komunikasi dan Penyiaran Islam', 'Bimbingan dan Konseling Islam'],
            'Fakultas Ekonomi dan Bisnis Islam' => ['Ekonomi Syariah', 'Perbankan Syariah', 'Manajemen Bisnis Syariah'],
        ];

        $fakultas = $this->faker->randomElement(array_keys($fakultasDanProdi));
        $prodi = $this->faker->randomElement($fakultasDanProdi[$fakultas]);

        return [
            'user_id' => User::factory(),
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_hp' => $this->faker->phoneNumber(),
            'prodi' => $prodi,
            'fakultas' => $fakultas,
            'angkatan' => $this->faker->numberBetween(2020, 2024),
            'ip' => $this->faker->randomFloat(2, 3.00, 4.00),
            'ipk' => $this->faker->randomFloat(2, 3.00, 4.00),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Mahasiswa $mahasiswa) {
            // berikan role 'mahasiswa'.
            $mahasiswa->user->assignRole('mahasiswa');

            $beasiswasToAttach = Beasiswa::inRandomOrder()->limit($this->faker->numberBetween(1, 3))->get();

            // Lampirkan beasiswa ke mahasiswa dengan data pivot tambahan
            foreach ($beasiswasToAttach as $beasiswa) {
                $mahasiswa->beasiswas()->attach($beasiswa->id, [
                    'tahun_penerimaan' => $this->faker->numberBetween(2021, 2025),
                ]);
            }
        });
    }
}
