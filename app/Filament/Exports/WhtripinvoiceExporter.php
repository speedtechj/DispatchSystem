<?php

namespace App\Filament\Exports;

use App\Models\Whtripinvoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class WhtripinvoiceExporter extends Exporter
{
    protected static ?string $model = Whtripinvoice::class;

    public static function getColumns(): array
    {
        return [

            ExportColumn::make('whdeliverylog.trip_number')
            ->label('Trip Number'),
            ExportColumn::make('truck.plate_no')
            ->label('Plate Number'),
            ExportColumn::make('invoice.invoice')
            ->label('Invoice'),
             ExportColumn::make('invoice.sender_name')
            ->label('Sender'),
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
            ExportColumn::make('is_unloaded')
            ->label('Unloaded')
            ->state(function (Model $record) {
                return $record->is_unloaded ? 'Yes' : 'No';
            }),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your whtripinvoice export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
