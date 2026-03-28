<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CitabicProcess;
use App\Models\CitabicProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcessController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = CitabicProcess::query();
            $table = datatables()->of($query);
            $table->addColumn('actions', function ($row) {
                $actions = [
                    [
                        'type' => 'link',
                        'classNames' => 'btn-sm btn-light-primary',
                        'icon' => 'fa fa-pen',
                        'link' => route('admin.processes.edit', $row->id),
                        'attributes' => [
                            'data-bs-toggle' => 'tooltip',
                            'data-bs-placement' => 'top',
                            'title' => __('admin.common.edit'),
                            'aria-label' => __('admin.common.edit'),
                        ],
                    ],
                    [
                        'type' => 'destroy',
                        'link' => route('admin.processes.destroy', $row->id),
                    ],
                ];

                return view('admin.layouts.data-table-actions', compact('actions'));
            })->rawColumns(['actions']);

            return $table->make(true);
        }

        $processes = CitabicProcess::query()->latest()->get();

        return view('admin.processes.index', compact('processes'));
    }

    public function create(): View
    {
        return view('admin.processes.form', [
            'process' => new CitabicProcess,
            'form' => $this->formData(null),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $profile = CitabicProfile::query()->firstOrFail();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $profile->processes()->create($data);

        return redirect()->route('admin.processes.index')->with('status', 'Process created successfully.');
    }

    public function edit(CitabicProcess $process): View
    {
        return view('admin.processes.form', [
            'process' => $process,
            'form' => $this->formData($process),
        ]);
    }

    public function update(Request $request, CitabicProcess $process): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'en' => 'nullable|array',
        ]);

        $data['translations'] = ['en' => $data['en'] ?? []];
        unset($data['en']);

        $process->update($data);

        return redirect()->route('admin.processes.index')->with('status', 'Process updated successfully.');
    }

    public function destroy(CitabicProcess $process): RedirectResponse
    {
        $process->delete();

        return redirect()->route('admin.processes.index')->with('status', 'Process deleted successfully.');
    }

    private function formData(?CitabicProcess $process): array
    {
        return [
            'title' => old('title', $process?->title),
            'description' => old('description', $process?->description),
            'en' => old('en', $process?->translations['en'] ?? []),
        ];
    }
}
