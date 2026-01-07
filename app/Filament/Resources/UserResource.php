<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Company;
use Filament\Tables\Table;
use App\Models\Logistichub;
use App\Models\Workposition;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
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
use App\Filament\Resources\UserResource\Pages;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
protected static string | UnitEnum | null $navigationGroup = 'Settings';
  //  protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Personal Information')
                            ->schema([
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('middle_name')
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('address')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('mobile_number')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                Select::make('panelcategory_id')
                                    ->label('Panel Category')
                                    ->relationship(name: 'panelcategory', titleAttribute: 'description')
                                     ->required(), 
                                Select::make('logistichub_id')
                                ->label('Logistic Hub/Location')
                                ->options(Logistichub::query()->pluck('hub_name', 'id'))
                                ->required(),
                                Select::make('workposition_id')
                                    ->label('Work Position')
                                      ->options(Workposition::query()->pluck('position_description', 'id'))
                                         ->required(),
                                Toggle::make('is_admin')
                                    ->label('Admin')
                                    ->required(),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->required(),
                                Toggle::make('is_crew')
                                    ->label('Crew')
                                    ->required(),

                                Select::make('roles')
                        ->multiple()
                        ->relationship('roles', 'name')
                        ->preload(),

                            ])->columns(3)

                    ])->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('company_id')
                                    ->label('Company')
                                   ->relationship(name: 'company', 
                                   titleAttribute: 'company_name',
                                   modifyQueryUsing: fn (Builder $query) => $query->where('is_active', true)
                                   )
                                     ->required(), 
                                FileUpload::make('profile_picture')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->circleCropper()
                                    // ->panelLayout('grid')
                                    ->uploadingMessage('Uploading attachment...')
                                    ->openable()
                                    ->getUploadedFileNameForStorageUsing(function ($file, Get $get) {
                                        return $get('last_name') . '.' . $file->getClientOriginalExtension();
                                    })
                                    ->maxSize(1024)
                                    ->disk('public')
                                    ->directory('userpictures')
                                    ->visibility('private')
                                    ->removeUploadedFileButtonPosition('right')
                                    ->label('Profile Picture'),
                                TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->dehydrated(fn($state) => filled($state))
                                    ->maxLength(255)
                                    ->hiddenOn(EditUser::class)
                                    ->maxLength(255),
                            ])
                    ])->columnSpan(['lg' => 1])


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('middle_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('mobile_number')
                    ->searchable(),
                IconColumn::make('is_admin')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
