<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori';

    protected $guarded = ['id'];

    public function beasiswa(): BelongsToMany
    {
        return $this->belongsToMany(Beasiswa::class, 'beasiswa_kategori')
            ->withTimestamps();
    }
}
