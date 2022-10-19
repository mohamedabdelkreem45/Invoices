<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $request->validate([
            'pic' => 'required|mimes:png,jpg,jpeg,pdf'
        ],[
            'pic.required' => 'يجب ادخال مرفق',
            'pic.mimes' => 'png,jpg,jpeg,pdf المرفق يجب ان يكون من نوع '
        ]);

        $file_name = $request->pic->getClientOriginalName();

        invoice_attachment::create([
            'invoice_id' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'created_by' => Auth::user()->name,
            'file_name' => $file_name
        ]);

        $request->pic->move(public_path('Attachments/' . $request->invoice_number), $file_name);

        session()->flash('add', 'تم اضافه المرفق');
        return back();
    }


    public function show(invoice_attachment $invoice_attachment)
    {
        //
    }

    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
    }

    public function remove_attachments(Request $request){
        invoice_attachment::where('id', $request->file_id)->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
}