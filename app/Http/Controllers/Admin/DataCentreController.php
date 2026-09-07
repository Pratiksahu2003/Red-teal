<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataCentre;
use App\Models\DataCentreFeature;
use App\Models\DataCentreGallery;
use App\Models\DataCentreSpecification;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataCentreController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        $dataCentre = DataCentre::instance();

        return view('admin.data-centre.index', [
            'dataCentre' => $dataCentre,
            'specifications' => $dataCentre->specifications()->get(),
            'features' => $dataCentre->features()->get(),
            'gallery' => $dataCentre->gallery()->get(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'hero_video_url' => 'nullable|url|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'cta_heading' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:100',
            'cta_button_url' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|max:5120',
        ]);

        $dataCentre = DataCentre::instance();

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $this->uploadImage($request->file('hero_image'), 'data-centre', $dataCentre->hero_image);
        } else {
            unset($validated['hero_image']);
        }

        $dataCentre->update($validated);

        return back()->with('success', 'Data centre information updated successfully.');
    }

    public function storeSpecification(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['data_centre_id'] = DataCentre::instance()->id;
        DataCentreSpecification::create($validated);

        return back()->with('success', 'Specification added successfully.');
    }

    public function updateSpecification(Request $request, DataCentreSpecification $specification)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $specification->update($validated);

        return back()->with('success', 'Specification updated successfully.');
    }

    public function destroySpecification(DataCentreSpecification $specification)
    {
        $specification->delete();

        return back()->with('success', 'Specification deleted successfully.');
    }

    public function storeFeature(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:5120',
        ]);

        $validated['data_centre_id'] = DataCentre::instance()->id;
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'data-centre/features');
        }

        DataCentreFeature::create($validated);

        return back()->with('success', 'Feature added successfully.');
    }

    public function updateFeature(Request $request, DataCentreFeature $feature)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'data-centre/features', $feature->image);
        } else {
            unset($validated['image']);
        }

        $feature->update($validated);

        return back()->with('success', 'Feature updated successfully.');
    }

    public function destroyFeature(DataCentreFeature $feature)
    {
        $this->deleteImage($feature->image);
        $feature->delete();

        return back()->with('success', 'Feature deleted successfully.');
    }

    public function gallery()
    {
        $dataCentre = DataCentre::instance();

        return view('admin.data-centre.gallery', [
            'gallery' => $dataCentre->gallery()->orderBy('sort_order')->get(),
        ]);
    }

    public function storeGallery(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'caption' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
        ]);

        $path = $this->uploadImage($request->file('image'), 'data-centre/gallery');

        DataCentreGallery::create([
            'data_centre_id' => DataCentre::instance()->id,
            'image' => $path,
            'caption' => $request->caption,
            'alt_text' => $request->alt_text,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Gallery image uploaded successfully.');
    }

    public function destroyGallery(DataCentreGallery $gallery)
    {
        $this->deleteImage($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }

    public function toggleGallery(DataCentreGallery $gallery)
    {
        $gallery->update(['is_active' => ! $gallery->is_active]);

        return back()->with('success', 'Gallery image status updated.');
    }
}
