<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class TableProduk extends BaseWidget
{
    protected static ?string $heading = 'Produk dengan Stok Paling Sedikit';
    protected static ?int $sort = 3;
    public static function canView(): bool
    {
        return Auth::user()->role !== 'pelanggan';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Produk::query()
                    ->orderBy('stok', 'asc')
                    ->limit(3)
            )
            ->columns([
                TextColumn::make('nama_produk')
                    ->label('Nama Produk')
                    ->sortable(),
                TextColumn::make('stok')
                    ->sortable(),
            ]);
    }
}