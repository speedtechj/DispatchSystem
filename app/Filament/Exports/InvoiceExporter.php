<?php

namespace App\Filament\Exports;

use App\Models\Consolidator;
use App\Models\Invoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class InvoiceExporter extends Exporter
{
    protected static ?string $model = Invoice::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('company')
            ->label('Company')
            ->state(function (Model $record) {
                return Consolidator::where('code', $record->location_code)->value('company_name');


    }),
          //  ExportColumn::make('container_id'),
            ExportColumn::make('invoice'),
            ExportColumn::make('batchno'),
            ExportColumn::make('sender_name'),
            ExportColumn::make('receiver_name'),
            ExportColumn::make('receiver_address'),
            ExportColumn::make('receiver_barangay'),
            ExportColumn::make('receiver_city'),
            ExportColumn::make('receiver_province'),
            ExportColumn::make('receiver_mobile_no'),
            ExportColumn::make('receiver_home_no'),
            ExportColumn::make('boxtype'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your invoice export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
