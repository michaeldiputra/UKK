<?php

namespace App\Filament\Resources\TransaksiResource\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\DB;

class TransaksiWidget extends BaseWidget
{
    protected static ?string $heading = 'Detail Transaksi'; 
    public $penjualanId;

    public function mount($record)
    {
        $this->penjualanId = is_array($record) ? $record['id'] : $record->id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\detailpenjualan::query()->where('penjualan_id', $this->penjualanId)
            )
            ->columns([
                TextColumn::make('produk.nama_produk')
                    ->label('Nama Produk'),
                TextColumn::make('jumlah_produk')
                    ->label('Jumlah Produk'),
                TextColumn::make('produk.harga')
                    ->label('Harga')
                    ->money('IDR'),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR'),
            ]);
    }
}