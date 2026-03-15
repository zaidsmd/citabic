<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;

class CompanyInfoController extends Controller
{
    public function index()
    {
        $fr_info = CompanyInfo::getAllInfo();
        $en_info = CompanyInfo::getAllInfo('en');
        return view('admin.company-info.index',compact('fr_info','en_info'));
    }
}
