<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $kepala = Pegawai::create([
            'nip' => '197508122000031001',
            'nama' => 'Drs. H. Ahmad Yani, M.Si.',
            'pangkat_gol' => 'Pembina Utama Muda, IV/c',
            'jabatan' => 'Kepala Instansi',
            'bagian' => 'Pimpinan',
            'atasan_id' => null,
        ]);

        $kabag = Pegawai::create([
            'nip' => '198205142005022002',
            'nama' => 'Siti Aminah, S.E., M.Si.',
            'pangkat_gol' => 'Pembina, IV/a',
            'jabatan' => 'Kepala Bagian Tata Usaha',
            'bagian' => 'Tata Usaha',
            'atasan_id' => $kepala->id,
        ]);

        Pegawai::create([
            'nip' => '199512102018011003',
            'nama' => 'Budi Setiawan, A.Md.',
            'pangkat_gol' => 'Pengatur, II/c',
            'jabatan' => 'Staf Administrasi',
            'bagian' => 'Tata Usaha',
            'atasan_id' => $kabag->id,
        ]);

        Pegawai::create([
            'nip' => '199803202021022004',
            'nama' => 'Rina Wijaya, S.Kom.',
            'pangkat_gol' => 'Penata Muda, III/a',
            'jabatan' => 'Pranata Komputer',
            'bagian' => 'Teknologi Informasi',
            'atasan_id' => $kabag->id,
        ]);
    }
}
