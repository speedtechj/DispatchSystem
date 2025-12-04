<?php

namespace App\Filament\Pages;

use App\Models\Company;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use App\Models\Companyprofile;
use Filament\Schemas\Components\Form;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use UnitEnum;
class Companyinfo extends Page
{
    protected string $view = 'filament.pages.companyinfo';
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
    protected ?string $heading = 'Scan Invoice';

    public ?array $data = [];

    public function mount(): void
    {
       $this->form->fill($this->getRecord()?->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    Section::make()
                    ->schema([
                        FileUpload::make('company_logo')
                            ->label('Company Logo')
                            ->preserveFilenames()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('logo')
                            ->visibility('private')
                            ->columnSpanFull(),
                        TextInput::make('company_name')
                            ->required(),
                        TextInput::make('company_address')
                            ->required(),
                          TextInput::make('company_barangay')
                            ->required(),
                          TextInput::make('company_city')
                            ->required(),
                          TextInput::make('company_province')
                            ->required(),
                          TextInput::make('company_zipcode')
                            ->required(),
                        TextInput::make('company_mobile_no')
                            ->required(),
                          TextInput::make('company_office_no')
                            ->required(),
                        TextInput::make('company_email')
                            ->required(),
                        TextInput::make('website')
                            ->required(),
                ])->columns(2)
                    
                    
                    ])->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ])
            ->record($this->getRecord())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $record = $this->getRecord();
    //    Companyprofile::updateOrCreate($this->data);
    //     $data = $this->form->getState();
    //     $record = $this->getRecord();
      

       if(!$record){
          
          Companyprofile::create($data);
           Notification::make()
            ->success()
            ->title('Succesfully Created')
            ->send();
       }else {
            $record->fill($data);
            $record->save();
              Notification::make()
            ->success()
            ->title('Succesfully Updated')
            ->send();
          
       }
    //     
    }
    public function getRecord(): ?Companyprofile
    {
        return Companyprofile::query()->first();
    }
    
}
