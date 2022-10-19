<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Models\Invoice;
use App\Models\Invoice_detail;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/index', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

Route::delete('invoices_attachements/remove_attachments', [InvoiceAttachmentController::class, 'remove_attachments'])->name('invoices_attachements.remove_attachments');

Route::get('view_file/{file_name}/{invoice_number}', [InvoiceDetailController::class, 'view_file'])->name('view_file');

Route::get('dwonload_file/{file_name}/{invoice_number}', [InvoiceDetailController::class, 'dwonload_file'])->name('dwonload_file');

Route::get('section/{id}', [InvoiceController::class, 'getproduct'])->name('section');

Route::resource('invoices', InvoiceController::class);

Route::resource('invoices_details', InvoiceDetailController::class);

Route::resource('invoices_attachements', InvoiceAttachmentController::class);

Route::resource('sections', SectionController::class);

Route::resource('products', ProductController::class);





require __DIR__ . '/auth.php';

Route::get('/{page}', [AdminController::class, 'index']);
