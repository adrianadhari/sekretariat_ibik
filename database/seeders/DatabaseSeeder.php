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
                'password' => Hash::make('rektor'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Wakil Rektor I',
                'email' => 'warek1@email.com',
                'password' => Hash::make('warek1'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Wakil Rektor II',
                'email' => 'warek2@email.com',
                'password' => Hash::make('warek2'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Wakil Rektor III',
                'email' => 'warek3@email.com',
                'password' => Hash::make('warek3'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit IT',
                'email' => 'it@email.com',
                'password' => Hash::make('it'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit BAUM',
                'email' => 'baum@email.com',
                'password' => Hash::make('baum'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit HRD',
                'email' => 'hrd@email.com',
                'password' => Hash::make('hrd'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit Marketing',
                'email' => 'marketing@email.com',
                'password' => Hash::make('marketing'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit BAAK',
                'email' => 'baak@email.com',
                'password' => Hash::make('baak'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit Keuangan',
                'email' => 'keuangan@email.com',
                'password' => Hash::make('keuangan'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit BAPSI',
                'email' => 'bapsi@email.com',
                'password' => Hash::make('bapsi'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit LPPM',
                'email' => 'lppm@email.com',
                'password' => Hash::make('lppm'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit Perpustakaan',
                'email' => 'perpustakaan@email.com',
                'password' => Hash::make('perpustakaan'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit CDC',
                'email' => 'cdc@email.com',
                'password' => Hash::make('cdc'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit Pojok BEI',
                'email' => 'pojokbei@email.com',
                'password' => Hash::make('pojokbei'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit PPM',
                'email' => 'ppm@email.com',
                'password' => Hash::make('ppm'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit PPA',
                'email' => 'ppa@email.com',
                'password' => Hash::make('ppa'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit BPM',
                'email' => 'bpm@email.com',
                'password' => Hash::make('bpm'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Himpunan Mahasiswa Gabungan',
                'email' => 'hima@email.com',
                'password' => Hash::make('hima'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Himpunan Mahasiswa Teknologi Informasi',
                'email' => 'himati@email.com',
                'password' => Hash::make('himati'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Himpunan Mahasiswa Sistem Informasi',
                'email' => 'himasi@email.com',
                'password' => Hash::make('himasi'),
                'role' => 'unit_internal'
            ]
        );
        User::create(
            [
                'name' => 'Unit Laboratorium',
                'email' => 'laboratorium@email.com',
                'password' => Hash::make('laboratorium'),
                'role' => 'unit_internal'
            ]
        );
    }
}
