<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;


Route::get('/tripinv/{invoice}/printpdf', [InvoiceController::class, 'tripinvoice'])->name('invoicepdf');




