<?php

namespace App\Filament\Resources\Fasilitas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FasilitasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_fasilitas')
                    ->required(),
            ]);
    }
}
