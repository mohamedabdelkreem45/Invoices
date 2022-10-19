<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $sections = Section::all();

        //$products_sections = DB::select("SELECT * FROM products p right JOIN sections s ON p.section_id = s.id");

        return view('products.index', compact('products', 'sections'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $request->validate([
            "product_name" => 'required|max:255',
            "section_id" => 'required'
        ], [
            "product_name.required" => "يجب ادخال اسم المنتج",
            "section_id.required" => "يجب ادخال اسم القسم"
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'text' => $request->text
        ]);

        session()->flash('add', 'تم اضافه المنتج');
        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request)
    {
        $request->validate(
            ['product_name' => 'required|max:255'],
            ['product_name.required' => 'يرجى ادخال اسم المنتج']
        );

        $section_id = section::where('section_name', $request->section_name)->first()->id;

        Product::where('id', $request->id)->update([
            'section_id' => $section_id,
            'product_name' => $request->product_name,
            'text' => $request->text,
        ]);

        session()->flash('update', 'تم التعديل بنجاح');
        return redirect()->route('products.index');
    }

    public function destroy(request $request)
    {
        Product::where('id', $request->id)->delete();

        session()->flash('delete', 'تم مسح المنتج');
        return redirect()->route('products.index');
    }
}