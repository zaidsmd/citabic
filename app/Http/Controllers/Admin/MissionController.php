<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionTranslation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
class MissionController extends Controller
{
    public function index(): View
    {
        $missions = Mission::with('translations')->orderBy('order')->get();
        return view('admin.missions.index', compact('missions'));
    }
    public function create(): View
    {
        return view('admin.missions.form', [
            'mission' => new Mission(),
            'form'    => $this->formData(null),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'icon'             => 'nullable|string|max:2048',
            'order'            => 'required|integer',
            'fr'               => 'nullable|array',
            'fr.title'         => 'nullable|string|max:255',
            'fr.description'   => 'nullable|string',
            'en'               => 'nullable|array',
            'en.title'         => 'nullable|string|max:255',
            'en.description'   => 'nullable|string',
        ]);
        $mission = Mission::create([
            'icon'             => $data['icon'] ?? null,
            'order'            => $data['order'],
        ]);
        foreach (['fr', 'en'] as $locale) {
            MissionTranslation::create([
                'mission_id'  => $mission->id,
                'locale'      => $locale,
                'title'       => $data[$locale]['title'] ?? '',
                'description' => $data[$locale]['description'] ?? '',
            ]);
        }
        return redirect()->route('admin.missions.index')->with('status', 'Mission created successfully.');
    }
    public function edit(Mission $mission): View
    {
        return view('admin.missions.form', [
            'mission' => $mission,
            'form'    => $this->formData($mission),
        ]);
    }
    public function update(Request $request, Mission $mission): RedirectResponse
    {
        $data = $request->validate([
            'icon'             => 'nullable|string|max:2048',
            'order'            => 'required|integer',
            'fr'               => 'nullable|array',
            'fr.title'         => 'nullable|string|max:255',
            'fr.description'   => 'nullable|string',
            'en'               => 'nullable|array',
            'en.title'         => 'nullable|string|max:255',
            'en.description'   => 'nullable|string',
        ]);
        $mission->update([
            'icon'             => $data['icon'] ?? null,
            'order'            => $data['order'],
        ]);
        foreach (['fr', 'en'] as $locale) {
            MissionTranslation::updateOrCreate(
                ['mission_id' => $mission->id, 'locale' => $locale],
                [
                    'title'       => $data[$locale]['title'] ?? '',
                    'description' => $data[$locale]['description'] ?? '',
                ]
            );
        }
        return redirect()->route('admin.missions.index')->with('status', 'Mission updated successfully.');
    }
    public function destroy(Mission $mission): RedirectResponse
    {
        if ($mission->icon) {
            Storage::disk('public')->delete($mission->icon);
        }
        $mission->delete();
        return redirect()->route('admin.missions.index')->with('status', 'Mission deleted successfully.');
    }
    public function uploadImage(Request $request, ImageUploadService $imageService): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240']);
        $path = $imageService->store($request->file('image'), 'missions');
        return response()->json([
            'path' => $path,
            'url'  => Storage::disk('public')->url($path),
        ]);
    }
    private function formData(?Mission $mission): array
    {
        $fr = $mission?->translations->firstWhere('locale', 'fr');
        $en = $mission?->translations->firstWhere('locale', 'en');
        return [
            'icon'             => old('icon', $mission?->icon),
            'order'            => old('order', $mission?->order ?? 0),
            'fr'               => old('fr', ['title' => $fr?->title ?? '', 'description' => $fr?->description ?? '']),
            'en'               => old('en', ['title' => $en?->title ?? '', 'description' => $en?->description ?? '']),
        ];
    }
}
