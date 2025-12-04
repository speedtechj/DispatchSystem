<?php

namespace App\Filament\Resources\Unmanifesteds\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class UnmanifestedsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice')
                    ->searchable(),
                TextColumn::make('container.container_no')
                    ->sortable(),
                TextColumn::make('container.consolidator.company_name')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([

                ViewAction::make(),
                Action::make('Send Email')
                     ->icon('heroicon-o-envelope')
                     ->color('info')
                    ->action(function ($record) {
                        dd($record);
                        // Implement your email sending logic here
                        // For example, you can use Laravel's Mail facade
                        // Mail::to($record->email)->send(new YourMailableClass($record));
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
