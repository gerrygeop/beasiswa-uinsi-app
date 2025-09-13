<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\BeasiswaFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_beasiswa',
        'jenis_beasiswa',
        'lembaga_penyelenggara',
        'besar_beasiswa',
        'periode',
        'deskripsi',
    ];

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany(Mahasiswa::class, 'beasiswa_mahasiswa')
            ->withPivot('tahun_penerimaan')
            ->withTimestamps();
    }
}
