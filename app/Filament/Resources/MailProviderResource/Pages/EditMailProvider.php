<?php

namespace App\Filament\Resources\MailProviderResource\Pages;

use App\Filament\Resources\MailProviderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMailProvider extends EditRecord
{
    protected static string $resource = MailProviderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    
}
