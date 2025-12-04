<?php

namespace App\Filament\Imports;


use App\Models\Invoice;
use App\Models\Container;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;
use Filament\Resources\RelationManagers\RelationManager;

class InvoiceImporter extends Importer
{
    protected static ?string $model = Invoice::class;

    public static function getColumns(): array
    {
        return [
            // ImportColumn::make('container_id'),
            
//    ->castStateUsing(function (float $state): ?float {
//         if (blank($state)) {
//             return null;
//         }
    
//         return 3;
//     }),
            ImportColumn::make('invoice')
            ->requiredMapping(),
            ImportColumn::make('batchno')
             ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('sender_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_address')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_province')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_city')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_barangay')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_mobile_no')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('receiver_home_no')
                ->requiredMapping(),
            ImportColumn::make('boxtype')
                ->requiredMapping(),

            ImportColumn::make('routearea_id')
                ->requiredMapping(),
             ImportColumn::make('location_code')
                ->requiredMapping()
            //     ->rules(['required', 'max:255']),
            // ImportColumn::make('routearea')
            //     ->numeric()
            //     ->rules(['integer']),
            // ImportColumn::make('is_verified')
            //     ->boolean()
            //     ->rules(['required', 'boolean']),
            // ImportColumn::make('is_delivered')
               
            //     ->boolean()
            //     ->rules(['required', 'boolean']),
            // ImportColumn::make('is_assigned')
               
            //     ->boolean()
            //     ->rules(['required', 'boolean']),
        ];
    }
    
    public function mutateBeforeCreate(array $data): array
{

    dd($data);
    // $data['tracking_number'] = str_pad($data['tracking_number'], 8, '0', STR_PAD_LEFT);

    // return $data;
}

    public function resolveRecord(): ?Invoice
    {

        // return Invoice::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     // 'email' => $this->data['email'],
        // ],[
        //     'container_id' => 3,
        // ]);
        // dd($this->data['boxtype']);




        return new Invoice([
            'container_id' =>   $this->options['container_id'],
        ]);
        // return new Invoice();
    }
   

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your invoice import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
    
}
