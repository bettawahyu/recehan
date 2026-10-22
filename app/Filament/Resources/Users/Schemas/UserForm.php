<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('no_hp')
                    ->tel()
                    ->maxLength(15),
                TextInput::make('email')
                    ->label('Email address')
                    ->unique(ignoreRecord: true)
                    ->readonly(fn (string $operation) => $operation === 'edit')
                    ->email()
                    ->helperText('Email address tidak dapat diubah setelah dibuat')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->revealable()
                    ->helperText('Kosongkan jika tidak ingin mengganti password')
                    ->required(fn (string $operation) => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state)),
                Textarea::make('alamat')
                    ->columnSpanFull(),
                TextInput::make('avatar_url')
                    ->label('Avatar')
                    ->url()
                    ->maxLength(255)
                    ->helperText('Masukkan URL gambar dari internet'),
                Select::make('roles')
                    ->label('Role')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->helperText('User nonaktif tidak bisa login ke panel maupun aplikasi mobile')
                    ->default(true)
                    ->disabled(fn ($record) => $record?->is(auth()->user())),
            ]);
    }
}
