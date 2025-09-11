<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function beasiswas(): BelongsToMany
    {
        return $this->belongsToMany(BeasiswaMahasiswa::class, 'beasiswa_mahasiswa')
            ->withPivot('tahun_penerimaan')
            ->withTimestamps();
    }
}
