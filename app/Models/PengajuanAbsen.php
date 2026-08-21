<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanAbsen extends Model
{
    protected $table = 'pengajuan_absen';

    protected $fillable = [
        'nomor_surat',
        'pegawai_id',
        'atasan_id',
        'jenis_absen',
        'alasan',
        'tanggal_lupa',
        'tanggal_pengajuan',
        'kota_surat',
        'status',
    ];

    protected $casts = [
        'tanggal_lupa' => 'date',
        'tanggal_pengajuan' => 'date',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function atasan(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id');
    }
}
