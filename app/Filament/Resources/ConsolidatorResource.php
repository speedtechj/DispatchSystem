<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ConsolidatorResource\Pages\ListConsolidators;
use App\Filament\Resources\ConsolidatorResource\Pages\CreateConsolidator;
use App\Filament\Resources\ConsolidatorResource\Pages\EditConsolidator;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Consolidator;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ConsolidatorResource\Pages;
use App\Filament\Resources\ConsolidatorResource\RelationManagers;
use UnitEnum;
class ConsolidatorResource extends Resource
{
    protected static ?string $model = Consolidator::class;
protected static string | UnitEnum | null $navigationGroup = 'Settings';
  //  protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-plus';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Section::make('Consolidator Information')
                        ->columnSpanFull()
                ->schema([
                    TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->maxLength(255),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('mobile_no')
                    ->required()
                    ->maxLength(255),
                TextInput::make('office_no')
                    ->maxLength(255),
                    
                TextInput::make('website')
                    ->maxLength(255),
                 TextInput::make('email')
                    ->maxLength(255)
                ]),
            ]),
            Group::make()
            ->schema([
                Section::make('Other Information')
                ->schema([
                    FileUpload::make('logo')
                    ->image()
                    ->imageEditor()
                    // ->panelLayout('grid')
                    ->uploadingMessage('Uploading attachment...')
                    ->openable()
                    ->maxSize(1024)
                    ->disk('public')
                    ->directory('consolidatorlogo')
                    ->visibility('private')
                    ->removeUploadedFileButtonPosition('right')
                    ->label('Logo')
                    ->columnSpanFull(),
                    FileUpload::make('company_document')
                    ->label('Document')
                    ->multiple()
                    ->panelLayout('grid')
                    ->uploadingMessage('Uploading attachment...')
                    ->openable()
                    ->disk('public')
                    ->directory('consolidatordoc')
                    ->visibility('private')
                    ->removeUploadedFileButtonPosition('right'),
                    Toggle::make('is_active')
                    ->label('Active')
                    ->required()
                    ->default(true),
                    Toggle::make('is_download')
                    ->label('Download')
                    ->required()
                    ->default(true),
                    Toggle::make('is_upload')
                    ->label('Upload')
                    ->required()
                    ->default(true),
                 
                ])
                ])->columns(3)
                
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('company_name')
                    ->searchable(),
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('mobile_no')
                    ->searchable(),
                TextColumn::make('office_no')
                    ->searchable(),
                TextColumn::make('user.full_name')
                ->label('Created By'),
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
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConsolidators::route('/'),
            'create' => CreateConsolidator::route('/create'),
            'edit' => EditConsolidator::route('/{record}/edit'),
        ];
    }
}
