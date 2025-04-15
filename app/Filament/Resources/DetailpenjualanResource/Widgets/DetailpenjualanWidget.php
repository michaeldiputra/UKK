<?php

namespace App\Filament\Resources\DetailpenjualanResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Summarizer;

class detailpenjualanWidget extends BaseWidget
{
    protected static ?string $heading = 'Daftar Produk';
    
    public $penjualanId;
    public function mount($record)
    {
        $this->penjualanId = $record;
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
                    ->money('IDR')
                    ->summarize(
                        Summarizer::make()
                            ->using(function ($query) {
                                return $query->sum(DB::raw('subtotal'));
                            })
                            ->money('IDR')
                    )
                ,
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
