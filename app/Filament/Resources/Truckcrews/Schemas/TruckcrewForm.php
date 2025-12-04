<?php

namespace App\Filament\Resources\Truckcrews\Schemas;

use App\Models\User;
use App\Models\Truck;
use Filament\Schemas\Schema;
use Filament\Support\Markdown;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;

class TruckcrewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('truck_id')
                    ->label('Truck')
                    ->options(Truck::all()->pluck('plate_no', 'id'))
                    ->unique()
                    ->required(),
                Select::make('driver')
                    ->options(User::all()->pluck('full_name', 'id'))
                    ->required(),
                Select::make('leadman')
                    ->required()
                   ->options(User::all()->pluck('full_name', 'id')),
                Select::make('Porter')
                    ->required()
                    ->options(User::all()->pluck('full_name', 'id')),
               MarkdownEditor::make('remarks')
                    ->columnSpanFull(),
            ]);
    }
}
