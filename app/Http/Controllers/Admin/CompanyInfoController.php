<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInfoRequest;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    public function index(Request $request)
    {
        $info = CompanyInfo::getAllInfo();
        return view('admin.company-info.index', compact('info'));
    }


    public function update(CompanyInfoRequest $request)
    {
        $validatedData = $request->validated();

        foreach ($validatedData as $key => $value) {
            CompanyInfo::updateOrCreate(['key' => $key, 'lang' => 'fr'], ['value' => $value]);
        }

        return redirect()
            ->route('admin.company-info.index')
            ->with('status', __('admin.company_info.messages.updated'));
    }
}
