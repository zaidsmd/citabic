<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Handles HTTP endpoints for Contact Submission Controller.
 */
class ContactSubmissionController extends Controller
{
    /**
     * Display a listing for the resource.
     *
     * @param  Request  $request  Parameter.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = ContactSubmission::query()->latest();

            $table = datatables()->of($query)
                ->editColumn('message', function (ContactSubmission $submission): string {
                    return Str::limit((string) $submission->message, 80);
                })
                ->editColumn('created_at', function (ContactSubmission $submission): string {
                    return $submission->created_at?->format('d M Y H:i') ?? '-';
                })
                ->addColumn('actions', function (ContactSubmission $submission): View {
                    $actions = [
                        [
                            'type' => 'destroy',
                            'link' => route('admin.contact-submissions.destroy', $submission),
                        ],
                    ];

                    return view('admin.layouts.data-table-actions', compact('actions'));
                })
                ->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('admin.contact-submissions.index');
    }

    /**
     * Delete the specified resource.

     *

     * @param ContactSubmission $contactSubmission Parameter.

     * @param  Request  $request  Parameter.
     */
    public function destroy(ContactSubmission $contactSubmission, Request $request): RedirectResponse|JsonResponse
    {
        $contactSubmission->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 'ok']);
        }

        return redirect()
            ->route('admin.contact-submissions.index')
            ->with('status', 'Contact submission deleted successfully.');
    }
}
