<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TransaksiResource\Pages;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;
    protected static ?string $label = 'Histori Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $slug = 'histori-transaksi';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->role == 'pelanggan') {
            $userPhone = auth()->user()->nomor_telepon;
            $pelangganIds = Pelanggan::where('nomor_telepon', $userPhone)->pluck('id');
            return $query->whereIn('pelanggan_id', $pelangganIds);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Transaksi')
                    ->disabled(),

                Forms\Components\Select::make('pelanggan_id')
                    ->label('Pelanggan')
                    ->relationship('pelanggan', 'nama_pelanggan')
                    ->disabled(),

                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->disabled()
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('pelanggan.nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable(),

                TextColumn::make('total_harga')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([
                // 
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            // 'create' => Pages\CreateTransaksi::route('/create'),
            // 'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}