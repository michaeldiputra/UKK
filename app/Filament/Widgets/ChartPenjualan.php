<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChartPenjualan extends ChartWidget
{
    protected static ?string $heading = 'Total Penjualan Per Hari';
    protected static ?int $sort = 2;
    public static function canView(): bool
    {
        return Auth::user()->role !== 'pelanggan';
    }
    protected function getData(): array
    {
        $penjualan = DB::table('penjualans')
            ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('COUNT(*) as jumlah'))
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $jumlahPembelianTerbanyak = $penjualan->max('jumlah') ?? 0;

        $tanggalPalingLama = $penjualan->first()->tanggal ?? now()->startOfMonth()->toDateString();
        $tanggalPalingBaru = $penjualan->last()->tanggal ?? now()->endOfMonth()->toDateString();

        $data = $penjualan->pluck('jumlah')->toArray();

        $labels = $penjualan->pluck('tanggal')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data,
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => 'rgba(76, 175, 80, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}