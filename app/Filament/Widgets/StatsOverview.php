<?php

namespace App\Filament\Widgets;

use App\Models\pelanggan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login

class StatsOverview extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();

        $role = $user->role ?? 'Tidak Diketahui';

        $conditionalValue = $role === 'pelanggan'
            ? $user->nomor_telepon ?? 'Nomor telepon tidak tersedia'
            : $user->email ?? 'Email tidak tersedia';

        return [
            Stat::make('Role Anda', $role),
            Stat::make('Info Berdasarkan Role', $conditionalValue),
            Stat::make('Total Pelanggan', pelanggan::count()),
        ];
    }
}