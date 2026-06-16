<?php

namespace App\Filament\Resources\Kosts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;

class KostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_kost')
                    ->required(),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
                TextInput::make('jarak')
                    ->required()
                    ->numeric(),
                Select::make('jenis_kost')
                    ->options(['putra' => 'Putra', 'putri' => 'Putri', 'campur' => 'Campur'])
                    ->required(),
                Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('no_hp')
                    ->required(),
                Select::make('status')
                    ->options(['tersedia' => 'Tersedia', 'penuh' => 'Penuh'])
                    ->default('tersedia')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                FileUpload::make('foto')
                    ->image()
                    ->disk('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->directory('kost'),
                CheckboxList::make('fasilitas')
                    ->relationship('fasilitas', 'nama_fasilitas')
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
