<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(
            [
                'name' => 'Sekretariat',
                'email' => 'sekretariat@email.com',
                'password' => Hash::make('sekretariat'),
                'role' => 'sekretariat'
            ]
        );
        User::create(
            [
                'name' => 'Rektor',
                'email' => 'rektor@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Wakil Rektor I',
                'email' => 'warek1@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Wakil Rektor II',
                'email' => 'warek2@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Wakil Rektor III',
                'email' => 'warek3@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Dekan Fakultas Bisnis',
                'email' => 'dekanbisnis@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Dekan Fakultas Pariwisata & Informatika',
                'email' => 'dekansitipar@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Dekan Fakultas Vokasi',
                'email' => 'dekanvokasi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Dekan Fakultas Magister',
                'email' => 'dekanmagister@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S1 Akuntansi',
                'email' => 's1akuntansi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S1 Manajemen',
                'email' => 's1manajemen@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S1 Biokewirausahaan',
                'email' => 's1biokewirausahaan@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S1 Teknologi Informasi',
                'email' => 's1teknologiinformasi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S1 Sistem Informasi',
                'email' => 's1sisteminformasi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S1 Pariwisata',
                'email' => 's1pariwisata@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi Sarjana Terapan Akuntansi Bisnis Digital',
                'email' => 'akuntansibisdig@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi Sarjana Terapan Perbankan & Keuangan Digital',
                'email' => 'pkd@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi Sarjana Terapan Bisnis Digital',
                'email' => 'bisdig@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S2 Akuntansi',
                'email' => 's2akuntansi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Ketua Prodi S2 Manajemen',
                'email' => 's2manajemen@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'BAUM',
                'email' => 'baum@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Manajemen Asset',
                'email' => 'manajemenasset@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'HRD',
                'email' => 'hrd@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Marketing',
                'email' => 'marketing@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'IT',
                'email' => 'it@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'BAAK',
                'email' => 'baak@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'BAPSI',
                'email' => 'bapsi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Keuangan',
                'email' => 'keuangan@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'LPPM',
                'email' => 'lppm@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Perpustakaan',
                'email' => 'perpustakaan@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'CDC',
                'email' => 'cdc@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Pojok BEI',
                'email' => 'pojokbei@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'PPM',
                'email' => 'ppm@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'PPA',
                'email' => 'ppa@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'BPM',
                'email' => 'bpm@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Himpunan Mahasiswa',
                'email' => 'hima@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Laboratorium Akuntansi',
                'email' => 'labakuntansi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Laboratorium Komputer',
                'email' => 'labkomputer@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Laboratorium Bahasa',
                'email' => 'labbahasa@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Laboratorium Bank Mini',
                'email' => 'labbankmini@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'KEC',
                'email' => 'kec@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Harpas',
                'email' => 'harpas@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Mapala',
                'email' => 'mapala@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Marcomm',
                'email' => 'marcomm@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Hipmi',
                'email' => 'hipmi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'KAC',
                'email' => 'kac@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'CMC',
                'email' => 'cmc@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'KBMKK',
                'email' => 'kbmkk@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Futsal',
                'email' => 'futsal@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Formi',
                'email' => 'formi@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'KCM',
                'email' => 'kcm@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'KMBK',
                'email' => 'kmbk@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'KMKK',
                'email' => 'kmkk@email.com',
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Esport',
                'email' => 'esport@email.com',
                'role' => 'unit_internal'
            ]
        );
    }
}
