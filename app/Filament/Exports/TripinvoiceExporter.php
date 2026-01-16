<?php

namespace App\Filament\Exports;

use App\Models\Tripinvoice;
use Illuminate\Support\Number;
use Filament\Actions\Exports\Exporter;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class TripinvoiceExporter extends Exporter
{
    protected static ?string $model = Tripinvoice::class;

    public static function getColumns(): array
    {
        return [
             ExportColumn::make('deliverylog.trip_number')
            ->label('Trip Number'),
            // ExportColumn::make('invoice.container.consolidator.company_name')
            // ->label('Company'),
    //         ExportColumn::make('invoice.location_code')
    //         ->label('Company')
    //         ->state(function (Model $record): float {
    //     return $record->invoice;
    // }),
            ExportColumn::make('invoice')
            ->label('Invoice'),
            ExportColumn::make('invoice.receiver_name')
            ->label('Receiver'),
            ExportColumn::make('invoice.receiver_address')
            ->label('Address'),
            ExportColumn::make('invoice.receiver_barangay')
            ->label('Barangay'),
            ExportColumn::make('invoice.receiver_city')
            ->label('City'),
            ExportColumn::make('invoice.receiver_province')
            ->label('Province'),
            ExportColumn::make('invoice.boxtype')
            ->label('Boxtype'),
            // ExportColumn::make('invoice.batchno')
            // ->label('Batch No'),
            ExportColumn::make('invoice.routearea.description')
            ->label('Route Area'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tripinvoice export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
    
}
