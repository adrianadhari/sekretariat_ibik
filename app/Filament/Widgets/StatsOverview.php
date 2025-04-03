<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\External;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\LetterNumberRequest;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        if ($user->role === 'sekretariat') {
            return [
                Stat::make('Total Akun Internal', User::count()),
                Stat::make('Total Pihak Eksternal', External::count()),
                Stat::make('Total Surat Masuk', IncomingLetter::count()),
                Stat::make('Total Surat Keluar', OutgoingLetter::count()),
                Stat::make('Total Pengajuan Nomor Surat', LetterNumberRequest::count()),
                Stat::make('Pengajuan Surat Pending', LetterNumberRequest::where('status', 'Pending')->count()),
            ];
        } else {
            return [
                Stat::make('Surat Masuk Anda', IncomingLetter::whereHas(
                    'recipients',
                    fn($query) =>
                    $query->where('users.id', $user->id)
                )->count()),
                Stat::make('Pengajuan Surat Anda', LetterNumberRequest::where('user_id', $user->id)->count()),
                Stat::make('Surat Keluar Anda', OutgoingLetter::where('internal_sender_id', $user->id)->count()),
            ];
        }
    }
}
