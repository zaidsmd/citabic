<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionContent;

class SectionContentController extends Controller
{
    public function index()
    {
        $contents = SectionContent::all();
        return view('admin.sections.index',compact('contents'));
    }


    public function update()
    {

    }
}
