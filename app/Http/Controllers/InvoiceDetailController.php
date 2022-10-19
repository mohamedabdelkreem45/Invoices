<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachment;
use App\Models\Invoice_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice_detail  $invoice_detail
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_detail $invoice_detail)
    {
        //
    }


    public function edit($id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $details = Invoice_detail::where('invoice_id', $id)->get();
        $attachments = invoice_attachment::where('invoice_id', $id)->get();
        return view('invoices.details', compact('invoice', 'details', 'attachments'));
    }


    public function update(Request $request,  $invoice_detail)
    {
        //
    }

    public function destroy(request $request)
    {
       
    }

    public function view_file($file_name, $invoice_number)
    {
        $st = "Attachments/";
        $pathToFile = public_path($st . $invoice_number . "/" . $file_name);
        return response()->file($pathToFile);
    }

    public function dwonload_file($file_name, $invoice_number)
    {
        dd('sas');
        $st = "Attachments";
        $pathToFile = public_path($st . '/' . $invoice_number .  '/' . $file_name);
        $x = Storage::disk('public_uploads');
        return $pathToFile;
        return response()->download($pathToFile);

    }

}