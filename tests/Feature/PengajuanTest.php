<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pegawai;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengajuanTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_pengajuan_dapat_diakses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('pegawai');
    }

    public function test_dapat_menyimpan_pengajuan_absen_dengan_data_valid(): void
    {
        $atasan = Pegawai::create([
            'nip' => '197508122000031001',
            'nama' => 'Drs. H. Ahmad Yani, M.Si.',
            'pangkat_gol' => 'Pembina Utama Muda, IV/c',
            'jabatan' => 'Kepala Instansi',
            'bagian' => 'Pimpinan',
        ]);

        $pegawai = Pegawai::create([
            'nip' => '199512102018011003',
            'nama' => 'Budi Setiawan, A.Md.',
            'pangkat_gol' => 'Pengatur, II/c',
            'jabatan' => 'Staf Administrasi',
            'bagian' => 'Tata Usaha',
            'atasan_id' => $atasan->id,
        ]);

        $payload = [
            'pegawai_id' => $pegawai->id,
            'atasan_id' => $atasan->id,
            'jenis_absen' => 'tidak mengisi absensi masuk',
            'alasan' => 'Mati lampu lokal di rumah',
            'tanggal_lupa' => '2026-08-20',
            'tanggal_pengajuan' => '2026-08-21',
            'kota_surat' => 'Makassar',
        ];

        $response = $this->post('/pengajuan', $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('pengajuan_absen', [
            'pegawai_id' => $pegawai->id,
            'atasan_id' => $atasan->id,
            'alasan' => 'Mati lampu lokal di rumah',
        ]);
    }

    public function test_gagal_menyimpan_jika_data_tidak_lengkap(): void
    {
        $response = $this->post('/pengajuan', [
            'pegawai_id' => '',
            'atasan_id' => '',
        ]);

        $response->assertSessionHasErrors(['pegawai_id', 'atasan_id', 'jenis_absen', 'alasan', 'tanggal_lupa', 'tanggal_pengajuan', 'kota_surat']);
    }
}
