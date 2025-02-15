<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TugasAkhir;
use App\Models\PembimbingTA;
use App\Models\Bimbingan;
use App\Models\PersetujuanBimbingan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Arifin Nurmuhammad Syarifudin',
            'role' => 'mahasiswa',
            'username' => '1217050021',
            'password' => '1217050021'
        ]);

        
        User::create([
            'name' => 'Darryl Naufal Ardiaz',
            'role' => 'mahasiswa',
            'username' => '1217050031',
            'password' => '1217050031'
        ]);

        
        User::create([
            'name' => 'Dian Saputra',
            'role' => 'mahasiswa',
            'username' => '1217050037',
            'password' => '1217050037'
        ]);

        
        User::create([
            'name' => 'Bina Ragawan, M.T.',
            'role' => 'dosen',
            'username' => '0987654321',
            'password' => 'pabina'
        ]);

        User::create([
            'name' => 'Dedi Suhardi, S.T., M.Kom.',
            'role' => 'dosen',
            'username' => '12345678910',
            'password' => 'padedi'
        ]);
        
        User::create([
            'name' => 'Administrator',
            'role' => 'admin',
            'username' => 'admin',
            'password' => 'ifsakti'
        ]);

        TugasAkhir::create([
            'nim' => '1217050021',
            'judul' => 'Penerapan Machine Learning dalam Prediksi Harga Saham',
            'status' => 'diajukan',
        ]);
        
        TugasAkhir::create([
            'nim' => '1217050031',
            'judul' => 'Analisis Keamanan Jaringan Menggunakan IDS',
            'status' => 'diajukan',
        ]);
        
        TugasAkhir::create([
            'nim' => '1217050037',
            'judul' => 'Implementasi Blockchain untuk Sistem Keuangan',
            'status' => 'diajukan',
        ]);

        $pembimbing1 = User::where('username', '0987654321')->first()->id; // Dosen 1
        $pembimbing2 = User::where('username', '12345678910')->first()->id; // Dosen 2

        // Set pembimbing untuk masing-masing mahasiswa
        foreach (User::where('role', 'mahasiswa')->get() as $mahasiswa) {
            PembimbingTA::create([
                'dosen_id' => $pembimbing1,
                'mhs_id' => $mahasiswa->id,
                'peran' => 'pembimbing_1'
            ]);

            PembimbingTA::create([
                'dosen_id' => $pembimbing2,
                'mhs_id' => $mahasiswa->id,
                'peran' => 'pembimbing_2'
            ]);
        }

        foreach (User::where('role', 'mahasiswa')->get() as $mahasiswa) {
            Bimbingan::create([
                'mhs_id' => $mahasiswa->id,
                'tanggal_bimbingan' => now()->subDays(5),
                'bab' => 'I',
                'status' => 'diajukan',
            ]);
        
            Bimbingan::create([
                'mhs_id' => $mahasiswa->id,
                'tanggal_bimbingan' => now(),
                'bab' => 'II',
                'status' => 'diajukan',
            ]);
        }

        foreach (Bimbingan::all() as $bimbingan) {
            PersetujuanBimbingan::create([
                'bimbingan_id' => $bimbingan->id,
                'dosen_id' => $pembimbing1,
                'status' => ($bimbingan->bab) == 'I' ? 'disetujui': 'ditolak',
            ]);
        
            PersetujuanBimbingan::create([
                'bimbingan_id' => $bimbingan->id,
                'dosen_id' => $pembimbing2,
                'status' => ($bimbingan->bab) == 'I' ? 'disetujui': 'ditolak',
            ]);
        }

    }
}
