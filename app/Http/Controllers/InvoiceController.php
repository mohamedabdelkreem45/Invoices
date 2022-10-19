<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachment;
use App\Models\Invoice_detail;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::all();
        $invoice_details = Invoice_detail::all();
        $sections = Section::all();
        return view('invoices.index', compact('invoices', 'sections', 'invoice_details'));
    }


    public function create()
    {
        $sections = Section::all();
        return view('invoices.create', compact('sections'));
    }

    public function store(Request $request)
    {

        Invoice::create([
            'invoice_date' => $request->invoice_date,
            'section_id' => $request->section_id,
            'invoice_number' => $request->invoice_number,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note
        ]);

        $invoice_id = Invoice::latest()->first()->id;

        Invoice_detail::create([
            'invoice_id' => $invoice_id,
            'section_id' => $request->section_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'status' => 'غير مدفوعه',
            'value_status' => 0,
            'note' => $request->note,
            'user' => Auth::user()->name
        ]);

        if ($request->hasFile('pic')) {

            $file_name = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $request->invoice_number), $file_name);

            invoice_attachment::create([
                'invoice_id' => $invoice_id,
                'file_name' => $file_name,
                'invoice_number' => $request->invoice_number,
                'created_by' => Auth::user()->name
            ]);
        }

        session()->flash('add', 'تم اضافه الفاتوره بنجاح');

        return redirect()->route('invoices.index');
    }

    public function show(Invoice $invoice)
    {
        //
    }


    public function edit( $id)
    {
        $invoice = Invoice::where('id', $id)->first();
        $sections = Section::all();
        return view('invoices.edit', compact('invoice', 'sections'));
    }


    public function update(Request $request, $id)
    {

        $file_name = Invoice::where('id', $id)->first()->file_name;
        $invoice_number_old = Invoice::where('id', $id)->first()->invoice_number;


        $request->validate([
            'section_id' => 'required',
            'invoice_number' => 'required|unique:invoices',
            'due_date' => 'required|date',
            'amount_collection' => 'required|integer',
            'amount_commission' => 'required|integer',
            'discount' => 'required|integer',
            'rate_vat' => 'required',
            'note' => 'Nullable',
            'invoice_date' => 'date|required|Nullable'
        ]);

        invoice::where('id',$id)->update([

            'invoice_number' => $request->invoice_number,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
            'invoice_date' => $request->invoice_date,
            'section_id' => $request->section_id
        ]);

        Invoice_detail::where('invoice_id', $id)->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section_id' => $request->section_id,
            'note' => $request->note,
            'user' => Auth::user()->name,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        invoice_attachment::where('invoice_id', $id)->update([
            'invoice_number' => $request->invoice_number
        ]);

        rename(public_path('Attachments/' . $invoice_number_old), public_path('Attachments/' . $request->invoice_number));

        session()->flash('edit', 'تم تعديل الفاتوره');

        return redirect()->route('invoices.index');
    }

    public function destroy(request $request)

    {

        $file_name = invoice_attachment::where('invoice_id', $request->invoice_id)->first()->file_name;
        Invoice::where('id', $request->invoice_id)->delete();
        // Invoice_detail::where('invoice_id', $request->invoice_id)->delete();
        // invoice_attachment::where('invoice_id', $request->invoice_id)->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $file_name );
        session()->flash('delete', 'تم مسح الفاتوره');
        return redirect()->route('invoices.index');
    }

    public function getproduct($id)
    {
        $products = DB::table("products")->where('section_id', $id)->pluck('product_name', 'id');

        return json_encode($products);
    }
}