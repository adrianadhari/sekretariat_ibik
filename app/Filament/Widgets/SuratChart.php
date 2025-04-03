<?php

namespace App\Filament\Widgets;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class SuratChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Surat Masuk & Keluar (3 Bulan Terakhir)';

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $user = Auth::user();

        // Ambil bulan sekarang dan dua bulan sebelumnya
        $months = [
            now()->subMonths(2)->startOfMonth(),
            now()->subMonth()->startOfMonth(),
            now()->startOfMonth(),
        ];

        $suratMasukData = [];
        $suratKeluarData = [];

        foreach ($months as $month) {
            if ($user->role === 'sekretariat') {
                // Sekretariat melihat semua surat
                $suratMasuk = IncomingLetter::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();
                $suratKeluar = OutgoingLetter::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();
            } else {
                // Unit Internal hanya melihat surat mereka
                $suratMasuk = IncomingLetter::whereHas(
                    'recipients',
                    fn($query) =>
                    $query->where('users.id', $user->id)
                )->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();

                $suratKeluar = OutgoingLetter::where('internal_sender_id', $user->id)
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count();
            }

            $suratMasukData[] = $suratMasuk;
            $suratKeluarData[] = $suratKeluar;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Surat Masuk',
                    'data' => $suratMasukData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                ],
                [
                    'label' => 'Surat Keluar',
                    'data' => $suratKeluarData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
                ],
            ],
            'labels' => [
                now()->subMonths(2)->format('F'),
                now()->subMonth()->format('F'),
                now()->format('F'),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
