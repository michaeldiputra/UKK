<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource\Widgets\TransaksiWidget;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\TransaksiResource;

class ViewTransaksi extends ViewRecord
{
    protected static string $resource = TransaksiResource::class;
    
    public function getFooterWidgetsColumns(): int
    {
        return 1;
    }
    public function getFooterWidgets(): array
    {
        return [
            TransaksiWidget::class
        ];
    }
}
