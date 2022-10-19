<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $request->validate([
            'section_name' => 'required|unique:sections|max:255'
        ], [
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا'
        ]);

        Section::create(
            [
                'section_name' => $request->section_name,
                'description' => $request->description,
                'createdBy'   => Auth::user()->name
            ]
        );

        session()->flash('add', 'تم اضافه القسم بنجاح');
        return redirect()->route('sections.index');
    }

    public function show(Section $section)
    {
        //
    }

    public function edit(Section $section)
    {
        //
    }

    public function update(Request $request)
    {
        return $request;
        #validate on updated data
        $request->validate([
            "section_name" => "required|unique:sections|max:255"
        ], [
            "section_name.required" => "يرجى ادخال اسم القسم",
            "section_name.unique" => "هذا القسم مسجل مسبقا",
        ]);

        #Update In DataBase By Eloquent
        Section::where('id', $request->id)->update([
            "section_name" => $request->section_name,
            "description" => $request->description
        ]);
        #flashing session for edit
        session()->flash('edit', 'تم التعديل بنجاح');
        return redirect()->route('sections.index');
    }

    public function destroy(request $request)
    {
        Section::where('id', $request->id)->delete();
        session()->flash('delete', 'تم مسح القسم بنجاح');
        return redirect()->route('sections.index');
    }
}