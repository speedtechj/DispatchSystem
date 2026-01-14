<?php

namespace App\Filament\Resources\Workpositions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class WorkpositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('position_description')
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
                Select::make('panelcategory_id')
                    ->label('Panel Category')
                    ->relationship(name: 'panelcategory', titleAttribute: 'description')
                    ->required(),

                Toggle::make('is_crew')
                    ->hint('Indicates if this workposition is designated for crew members.')
                    ->label('Crew')
                    ->required(),



                
            ]);
    }
}
