<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInfoRequest;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

/**
 * Handles HTTP endpoints for Company Info Controller.
 */
class CompanyInfoController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     * @return mixed
     */
    public function index(Request $request)
    {
        $info = CompanyInfo::getAllInfo();

        return view('admin.company-info.index', compact('info'));
    }

    /**
     * Persist updates to the resource.

     *

     * @param CompanyInfoRequest $request Parameter.

     * @return mixed
     */
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
