<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Truckcrew;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use App\Models\Consolidator;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class InvoiceController extends Controller
{
  public function tripinvoice($invoice)
  {


    $invoice = Invoice::where('id', $invoice)->first();
    $tripinvoice = Tripinvoice::where('invoice_id', $invoice->id)->first();
    $truckcrew = Truckcrew::where('truck_id', $tripinvoice->deliverylog?->truck?->id)->first();
    $driver = User::where('id', $truckcrew?->driver)->first();
    $leadman = User::where('id', $truckcrew?->leadman)->first();
    $consolidator = Consolidator::where('code', $invoice->location_code)->first();
    $data['truck'] = $truckcrew->truck ?? '';
    $data['driver'] = $driver ?? ' ';
    $data['leadman'] = $leadman ?? ' ';
    $data['consolidator'] = $consolidator;
    $data['invoice'] = $invoice;
    $pdf = PDF::loadView("invoices.pdfinvoice", $data);
    $pdf->setOption('margin-top', '5mm');
    $pdf->setOption('margin-bottom', '5mm');
    $pdf->setOption('margin-right', '5mm');
    $pdf->setOption('margin-left', '5mm');
    return $pdf->inline();
  }
}
