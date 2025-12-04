<?php

namespace App\Filament\Resources;

use UnitEnum;
use BackedEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Group;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Filament\Resources\CompanyResource\Pages\EditCompany;
use App\Filament\Resources\CompanyResource\Pages\CreateCompany;
use App\Filament\Resources\CompanyResource\Pages\ListCompanies;
use App\Models\Logistichub;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationLabel = 'Company/Agent';
    public static ?string $label = 'Company/Agent';
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
  //  protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Section::make('Company Information')
                    ->schema([
                      
                        TextInput::make('company_name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_email')
                    ->label('Email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_mobileno')
                    ->label('Mobile Phone')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                TextInput::make('company_phone')
                    ->label('Office Phone')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('company_address')
                    ->label('Address')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('company_owner')
                    ->label('Owner Name')
                    ->required()
                    ->maxLength(255),

                Select::make('logistichub_id')
    ->label('Hub')
    ->options(Logistichub::query()
    ->pluck('hub_name', 'id')),
    
                    ])->columns(2)
                ])->columnSpan(['lg' => 2]),
                Group::make()
                ->schema([
                Section::make('Other Information')
                ->schema([
                    FileUpload::make('company_picture')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    // ->panelLayout('grid')
                    ->uploadingMessage('Uploading attachment...')
                    ->openable()
                    ->maxSize(1024)
                    ->disk('public')
                    ->directory('companypictures')
                    ->visibility('private')
                    ->removeUploadedFileButtonPosition('right')
                    ->label('Logo')
                    ->columnSpanFull(),
                FileUpload::make('company_document')
                    ->label('Document')
                    ->multiple()
                    // ->panelLayout('grid')
                    ->uploadingMessage('Uploading attachment...')
                    ->openable()
                    ->disk('public')
                    ->directory('companydoc')
                    ->visibility('private')
                    ->removeUploadedFileButtonPosition('right')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Active')
                    ->required(),
                ])
                
                ])->columnSpan(['lg' => 1])
                
                    
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('company_email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('company_mobileno')
                    ->label('Mobile No.')
                    ->searchable(),
                TextColumn::make('company_phone')
                    ->label('Office No.')
                    ->searchable(),
                TextColumn::make('company_address')
                    ->label('Address')
                    ->searchable(),
                TextColumn::make('company_owner')
                    ->label('Owner')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('user.full_name')
                    ->label('Created By')
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
            'index' => ListCompanies::route('/'),
            'create' => CreateCompany::route('/create'),
            'edit' => EditCompany::route('/{record}/edit'),
        ];
    }
}
