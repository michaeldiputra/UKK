<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Detailpenjualan;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DetailpenjualanResource\Pages;
use App\Filament\Resources\DetailpenjualanResource\RelationManagers;

class DetailpenjualanResource extends Resource
{
    protected static ?string $model = Detailpenjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false; //menyembunyikan navigation
    protected static ?string $label = 'Detail Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('penjualan_id')
                    ->default(request('penjualan_id'))
                    ->dehydrated(),
                Select::make('produk_id')
                    ->label('Nama Produk')
                    ->options(
                        \App\Models\Produk::pluck('nama_produk', 'id')
                    )
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $produk = \App\Models\Produk::find($state);
                        $harga = $produk->harga ?? 0;
                        $jumlahProduk = $get('jumlah_produk') ?? 1;

                        $set('harga', $harga);
                        $set('jumlah_produk', 1);
                        $set('subtotal', $harga * $jumlahProduk);
                    })
                    ->searchable()
                    ->required(),
                TextInput::make('jumlah_produk')
                    ->numeric()
                    // ->default('1')
                    ->minValue('1')
                    ->maxValue(function ($get) {
                        $produkId = $get('produk_id');
                        $produk = \App\Models\Produk::find($produkId);
                        return $produk ? $produk->stok : 0;
                    })
                    ->label(function ($get) {
                        $produkId = $get('produk_id');
                        $produk = \App\Models\Produk::find($produkId);
                        $stok = $produk ? $produk->stok : 0;
                        return ('Jumlah Produk (Stok:' . $stok . ')');
                    })
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $harga = $get('harga');
                        $jumlahProduk = $get('jumlah_produk') ?? 1;

                        $set('subtotal', $harga * $jumlahProduk);
                    })
                    ->debounce(600)
                    ->required(),
                TextInput::make('harga')
                    ->prefix('Rp')
                    ->disabled(),
                TextInput::make('subtotal')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                function (Detailpenjualan $record) {
                    $penjualanId = request('penjualan_id');

                    return detailpenjualan::query()->where('penjualan_id', $penjualanId);
                }
            )
            ->columns([
                TextColumn::make('produk.nama_produk')
                    ->label('Nama produk'),
                TextColumn::make('jumlah_produk')
                    ->label('Jumlah Produk'),
                TextColumn::make('produk.harga')
                    ->money('IDR')
                    ->label('Harga Produk'),
                TextColumn::make('subtotal')
                    ->money('IDR')
                    ->summarize(
                        Summarizer::make()
                            ->using(function ($query) {
                                return $query->sum(DB::raw('subtotal'));
                            })
                            ->money('IDR')
                    ),
            ])
            ->filters([
                // 
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDetailpenjualans::route('/'),
            'create' => Pages\CreateDetailpenjualan::route('/create'),
            // 'edit' => Pages\EditDetailpenjualan::route('/{record}/edit'),
        ];
    }
}
