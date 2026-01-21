<?php

namespace App\Filament\Exports;

use App\Models\Routeinvoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class RouteinvoiceExporter extends Exporter
{
    protected static ?string $model = Routeinvoice::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('invoice'),
            ExportColumn::make('batchno'),
            ExportColumn::make('sender_name'),
            ExportColumn::make('receiver_name'),
            ExportColumn::make('receiver_address'),
            ExportColumn::make('receiver_province'),
            ExportColumn::make('receiver_city'),
            ExportColumn::make('receiver_barangay'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your routeinvoice export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
