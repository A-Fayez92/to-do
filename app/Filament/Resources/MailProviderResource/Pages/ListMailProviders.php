<?php

namespace App\Filament\Resources\MailProviderResource\Pages;

use App\Filament\Resources\MailProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMailProviders extends ListRecords
{
    protected static string $resource = MailProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
