<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    protected $fillable = [
        'kode_mk',
        'judul',
        'deskripsi',
        'kategori',
        'uploaded_by',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
