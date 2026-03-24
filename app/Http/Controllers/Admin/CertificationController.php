<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CertificationController extends Controller
{
    public function create(): View
    {
        return view('admin.certifications.form', [
            'mode' => 'create',
            'certification' => null,
            'form' => [
                'name_fr' => old('name_fr', ''),
                'description_fr' => old('description_fr', ''),
                'name_en' => old('name_en', ''),
                'description_en' => old('description_en', ''),
                'slug' => old('slug', ''),
                'image_url' => null,
            ],
        ]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Certification::query()
                ->from('certifications as fr')
                ->where('fr.language', 'fr')
                ->select([
                    'fr.id',
                    'fr.slug',
                    'fr.name as name',
                    'fr.description as description',
                    'fr.image as image',
                ]);

            $table = datatables()->of($query)
                ->addColumn('image_preview', function ($row) {
                    if (!$row->image) {
                        return '<span class="text-muted">No image</span>';
                    }

                    $url = $this->imageUrl($row->image);

                    return '<img src="' . e($url) . '" alt="' . e($row->name) . '" class="rounded" style="height:50px; width:50px; object-fit:cover;">';
                })
                ->addColumn('actions', function ($row) {
                    $editButton = sprintf(
                        '<a href="%s"
   class="btn btn-sm btn-light-primary me-1"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="' . __('admin.common.edit') . '"
   aria-label="' . __('admin.common.edit') . '">
    <i class="fa fa-pen"></i>
</a>',
                        route('admin.certifications.edit', $row->id)
                    );


                    $deleteForm = sprintf(
                        '<button data-table-action="delete"  data-href="%s"
   class="btn btn-sm btn-light-danger"
   data-bs-toggle="tooltip"
   data-bs-placement="top"
   title="' . __('admin.common.delete') . '"
   aria-label="' . __('admin.common.delete') . '">
    <i class="fa fa-trash-alt"></i>
</button>',
                        route('admin.certifications.destroy', $row->id)
                    );



                    return $editButton . $deleteForm;
                })
                ->rawColumns(['image_preview', 'actions']);

            return $table->make(true);
        }

        return view('admin.certifications.index');
    }

    public function edit(Certification $certification): View
    {
        $pairSlug = $certification->slug;
        $fr = Certification::query()->where('slug', $pairSlug)->where('language', 'fr')->first() ?? $certification;
        $en = Certification::query()->where('slug', $pairSlug)->where('language', 'en')->first();

        return view('admin.certifications.form', [
            'mode' => 'edit',
            'certification' => $certification,
            'form' => [
                'name_fr' => old('name_fr', $fr->name),
                'description_fr' => old('description_fr', $fr->description),
                'name_en' => old('name_en', $en?->name ?? ''),
                'description_en' => old('description_en', $en?->description ?? ''),
                'slug' => old('slug', $fr->slug),
                'image_url' => $this->imageUrl($fr->image),
            ],
        ]);
    }

    public function store(Request $request, ImageUploadService $imageService): RedirectResponse
    {
        if (!$request->hasFile('image') && $request->hasFile('file')) {
            $request->files->set('image', $request->file('file'));
        }

        $data = $request->validate([
            'name_fr' => ['required', 'string', 'max:255'],
            'description_fr' => ['required', 'string', 'max:1000'],
            'name_en' => ['required', 'string', 'max:255'],
            'description_en' => ['required', 'string', 'max:1000'],
            'image' => ['required', 'image', 'max:5120'],
        ]);

        $slug = $this->buildUniqueSlug($data['name_fr']);
        $imagePath = $imageService->store($request->file('image'), 'certifications');

        Certification::create([
            'name' => $data['name_fr'],
            'slug' => $slug,
            'description' => $data['description_fr'],
            'language' => 'fr',
            'image' => $imagePath,
        ]);
        Certification::create([
            'name' => $data['name_en'],
            'slug' => $slug,
            'description' => $data['description_en'],
            'language' => 'en',
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.certifications.index')->with('status', 'Certification created successfully.');
    }

    public function update(Request $request, Certification $certification, ImageUploadService $imageService): RedirectResponse
    {
        if (!$request->hasFile('image') && $request->hasFile('file')) {
            $request->files->set('image', $request->file('file'));
        }

        $data = $request->validate([
            'name_fr' => ['required', 'string', 'max:255'],
            'description_fr' => ['required', 'string', 'max:1000'],
            'name_en' => ['required', 'string', 'max:255'],
            'description_en' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $pairSlug = $certification->slug;
        $fr = Certification::query()->where('slug', $pairSlug)->where('language', 'fr')->first() ?? $certification;
        $en = Certification::query()->where('slug', $pairSlug)->where('language', 'en')->first();
        if (!$en) {
            $en = new Certification([
                'slug' => $pairSlug,
                'language' => 'en',
            ]);
        }

        $newSlug = $this->buildUniqueSlug($data['name_fr'], $pairSlug);
        $imagePath = $fr->image;

        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $imageService->store($request->file('image'), 'certifications');
        }

        $fr->fill([
            'name' => $data['name_fr'],
            'slug' => $newSlug,
            'description' => $data['description_fr'],
            'language' => 'fr',
            'image' => $imagePath,
        ])->save();

        $en->fill([
            'name' => $data['name_en'],
            'slug' => $newSlug,
            'description' => $data['description_en'],
            'language' => 'en',
            'image' => $imagePath,
        ])->save();

        return redirect()->route('admin.certifications.index')->with('status', 'Certification updated successfully.');
    }

    public function destroy(Certification $certification): RedirectResponse
    {
        $records = Certification::query()->where('slug', $certification->slug)->get();
        $imagePath = $records->firstWhere('language', 'fr')?->image ?? $records->first()?->image;

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        Certification::query()->where('slug', $certification->slug)->delete();

        return redirect()->route('admin.certifications.index')->with('status', 'Certification deleted successfully.');
    }

    private function imageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private function buildUniqueSlug(string $source, ?string $currentSlug = null): string
    {
        $baseSlug = Str::slug($source);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'certification';
        $slug = $baseSlug;
        $counter = 1;

        while (
        Certification::query()
            ->where('slug', $slug)
            ->when($currentSlug, fn($query) => $query->where('slug', '!=', $currentSlug))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
