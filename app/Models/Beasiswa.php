<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Beasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\BeasiswaFactory> */
    use HasFactory;

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany(Mahasiswa::class, 'beasiswa_mahasiswa')
            ->withPivot('tahun_penerimaan')
            ->withTimestamps();
    }
}
