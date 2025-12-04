<?php

namespace App\Filament\Resources;

use Closure;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Truck;
use Filament\Tables\Table;
use App\Models\Logistichub;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\TruckResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TruckResource\Pages\EditTruck;
use App\Filament\Resources\TruckResource\Pages\ListTrucks;
use App\Filament\Resources\TruckResource\RelationManagers;
use App\Filament\Resources\TruckResource\Pages\CreateTruck;
use UnitEnum;
class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;
protected static string | UnitEnum | null $navigationGroup = 'Settings';
   // protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-truck';
    public static ?string $label = 'Vehicles';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('vehicles Information')
                            ->schema([
                                TextInput::make('category')
                                    ->hint('Ex. Ten Wheeler, Truck, Mini Truck or Van')
                                    ->hintColor('warning')
                                    ->hintIcon('heroicon-m-truck')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('description')
                                    ->hint('Ex Brand, Color, Model')
                                    ->hintColor('warning')
                                    ->hintIcon('heroicon-m-truck')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('registration_no')
                                    ->label('Registration Number')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('plate_no')
                                    ->label('Plate Number')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('logistichub_id')
                                ->label('Logistic Hub/Location')
                                ->options(Logistichub::query()->pluck('hub_name', 'id'))
                                ->required(),
                                MarkdownEditor::make('Note')
                                    ->columnSpanFull(),
                            ])

                    ]),
                Group::make()
                    ->schema([
                        Section::make('Other Information')
                            ->schema([
                                FileUpload::make('truck_picture')
                                ->image()
                                ->avatar()
                                ->imageEditor()
                                ->circleCropper()
                                ->uploadingMessage('Uploading attachment...')
                                ->openable()
                                ->maxSize(1024)
                                ->disk('public')
                                ->directory('truckypictures')
                                ->visibility('private')
                                ->removeUploadedFileButtonPosition('right')
                                ->label('Vehicles Picture')
                                ->columnSpanFull(),
                                DatePicker::make('date_registered')
                                    ->native(false)
                                    ->closeOnDateSelection(true)
                                    ->label('Date Register')
                                    ->required(),
                                DatePicker::make('date_expired')
                                    ->label('Registration Expiration Date')
                                    ->native(false)
                                    ->closeOnDateSelection(true)
                                    ->required()
                                    ->rules(['after_or_equal:today']),
                                    Toggle::make('is_active')
                                    ->default(true)
                                    ->required(),
                            ])

                    ])



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('truck_picture')
                ->label('Vehicle Picture'),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('registration_no')
                    ->searchable(),
                TextColumn::make('plate_no')
                    ->searchable(),
              TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->sortable(),
                TextColumn::make('date_registered')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_expired')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => ListTrucks::route('/'),
            'create' => CreateTruck::route('/create'),
            'edit' => EditTruck::route('/{record}/edit'),
        ];
    }
}
