<?php

namespace App\Filament\Resources\DetailpenjualanResource\Pages;

use Filament\Actions;
use Illuminate\Support\Js;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DetailpenjualanResource;

class CreateDetailpenjualan extends CreateRecord
{
    protected static string $resource = DetailpenjualanResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah')
                ->submit('create')
                ->keyBindings(['mod+s']),
            Action::make('cancel')
                ->label('Simpan')
                ->alpineClickHandler('document.referrer ? window.history.back() : (window.location.href = ' . Js::from($this->previousUrl ?? static::getResource()::getUrl()) . ')')
                ->color('gray'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $id = $this->record->penjualan_id;
        return route(
            'filament.admin.resources.detailpenjualans.create',
            ['penjualan_id' => $id]
        );
    }

}
