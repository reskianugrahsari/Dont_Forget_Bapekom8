<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'pangkat_gol',
        'jabatan',
        'bagian',
        'atasan_id',
    ];

    public function atasan(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }

    public function bawahan(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'atasan_id');
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(PengajuanAbsen::class, 'pegawai_id');
    }

    public function persetujuan(): HasMany
    {
        return $this->hasMany(PengajuanAbsen::class, 'atasan_id');
    }
}
