<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasFactory, SoftDeletes;

    public function beasiswas(): BelongsToMany
    {
        return $this->belongsToMany(BeasiswaMahasiswa::class, 'beasiswa_mahasiswa')
            ->withPivot('tahun_penerimaan')
            ->withTimestamps();
    }
}
