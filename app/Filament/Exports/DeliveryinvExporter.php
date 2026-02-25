<?php

namespace App\Filament\Exports;

use App\Models\Consolidator;
use App\Models\Deliveryinv;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class DeliveryinvExporter extends Exporter
{
    protected static ?string $model = Deliveryinv::class;

    public static function getColumns(): array
    {
        return [
             ExportColumn::make('company')
            ->label('Company')
            ->state(function (Model $record) {
                return Consolidator::where('code', $record->invdata->location_code)->value('company_name');
    }),
            ExportColumn::make('invdata.invoice')->label('Invoice No.'),
            ExportColumn::make('invdata.sender_name')->label('Sender'),
            ExportColumn::make('invdata.receiver_name')->label('Receiver'),
            ExportColumn::make('invdata.receiver_address')->label('Receiver Address'),
            ExportColumn::make('invdata.receiver_barangay')->label('Receiver Barangay'),
            ExportColumn::make('invdata.receiver_city')->label('Receiver City'),
            ExportColumn::make('invdata.receiver_province')->label('Receiver Province'),
            ExportColumn::make('invdata.boxtype')->label('Box Type'),
         //   ExportColumn::make('is_delivered')->label('Delivered'),

            // ExportColumn::make('deliverylog_id'),
            // ExportColumn::make('invoice_id'),
            // ExportColumn::make('is_loaded'),
            // ExportColumn::make('is_delivered'),
            // ExportColumn::make('logistichub_id'),
            // ExportColumn::make('delivery_picture'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
            // ExportColumn::make('deliveryloghub_id'),
            // ExportColumn::make('is_loaded_hub'),
            // ExportColumn::make('hub_assigned'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your deliveryinv export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
