<?php

namespace App\Filament\Resources\Invoiceissues\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvoiceissuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('container.container_no')
                    ->sortable(),
                TextColumn::make('user.fullname')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('boxissue.issue_type')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            //    ->slideOver(),
            //     Action::make('Send Email')
            //    ->icon('heroicon-o-envelope')
            //    ->color('info')
            //     ->label('Send Email')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
              //      DeleteBulkAction::make(),
                ]),
            ]);
    }
}
