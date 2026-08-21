<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PengajuanAbsen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    public function index(): View
    {
        $pegawai = Pegawai::with('atasan')->orderBy('nama')->get();

        return view('pengajuan', compact('pegawai'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pegawai_id' => ['required', 'exists:pegawai,id'],
            'atasan_id' => ['required', 'exists:pegawai,id'],
            'jenis_absen' => ['required', 'string'],
            'alasan' => ['required', 'string', 'max:1000'],
            'tanggal_lupa' => ['required', 'date'],
            'tanggal_pengajuan' => ['required', 'date'],
            'kota_surat' => ['required', 'string', 'max:50'],
        ]);

        PengajuanAbsen::create($validated);

        return redirect()->back()->with('success', 'Permohonan berhasil disimpan!');
    }
}
