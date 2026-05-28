<?php

namespace App\Filament\Exports;

use App\Models\Consolidator;
use App\Models\Deliverylog;
use App\Models\Invoice;
use App\Models\Tripinvoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
//use Log;

class TripinvoiceExporter extends Exporter
{
    protected static ?string $model = Tripinvoice::class;

    public static function getColumns(): array
    {
        return [
             ExportColumn::make('trip_number')
            ->label('Trip Number')
            ->state(function (Model $record) {

             if ($record->deliveryloghub_id) {
                return Deliverylog::where('id', $record->deliveryloghub_id)->value('trip_number');
             }else {
                return $record->deliverylog->trip_number;
             }

              //   return $record->deliverylog->trip_number;
            }),
            // ExportColumn::make('invoice.container.consolidator.company_name')
            // ->label('Company'),
            ExportColumn::make('company')
            ->label('Company')
            ->state(function (Model $record) {
                return Consolidator::where('code', $record->invdata->location_code)->value('company_name');


    }),
            ExportColumn::make('invoice')
            ->label('Invoice'),
            ExportColumn::make('invdata.is_priority')
            ->label('Is Priority')
            ->state(function (Model $record) {
                return $record->invdata->is_priority ? 'Yes' : 'No';
            }),
            ExportColumn::make('invdata.batchno')
            ->label('Batch'),
            ExportColumn::make('invdata.receiver_name')
            ->label('Receiver'),
            ExportColumn::make('invdata.receiver_address')
            ->label('Address'),
            ExportColumn::make('invdata.receiver_barangay')
            ->label('Barangay'),
            ExportColumn::make('invdata.receiver_city')
            ->label('City'),
            ExportColumn::make('invdata.receiver_province')
            ->label('Province'),
            ExportColumn::make('invdata.boxtype')
            ->label('Boxtype'),
            ExportColumn::make('invoiceissue.boxissue.issue_type')
            ->label('Issue Type'),
            // ExportColumn::make('invoice.batchno')
            // ->label('Batch No'),
            // ExportColumn::make('invdata.routearea.description')
            // ->label('Route Area'),
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
