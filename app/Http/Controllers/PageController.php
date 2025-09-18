<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        $page = Page::where('slug', $slug)->first() ?? null;

        return Inertia::render('DynamicPage', [
            'pageContent' => $page ?? (object)[]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia::render('PublicPages/PageEditor', [

        ]);
    }

    public function home()
    {
        return inertia::render('EditHome', [
            $page = Page::where('slug', '/')->firstOrFail()
        ]);
    }
    public function getHeroSlides()
    {
        $page = Page::where('slug', '/')
            ->select('id', 'sliders')
            ->firstOrFail();

        return response()->json([
            'id' => $page->id,
            'sliders' => json_decode($page->sliders, true) ?? []
        ]);
    }

    public function updateHomeSlider(Request $request)
    {
        $page = Page::where('slug', '/')->firstOrFail();
        $slides = [];
        foreach ($request->input('sliders', []) as $index => $slideData) {
            $image = null;
            if ($request->hasFile("sliders.$index.image")) {
                $file = $request->file("sliders.$index.image");
                $image = $file->store('hero_sliders', 'public'); // store in public storage
            } elseif (!empty($slideData['image'])) {
                $image = $slideData['image'];
            }

            $slides[] = [
                'image' => $image,
                'text' => $slideData['text'] ?? null
            ];
        }

        // Save JSON in the page
        $page->sliders = json_encode($slides);
        $page->save();

        return response()->json([
            'message' => 'Home slider updated successfully',
            'slides' => $slides
        ]);
    }


    public function adminView()
    {
        return inertia::render('PublicPages/Pages', [
            'pages' => Page::latest()->paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        $page = new Page();
        $page->slug = Str::slug($request->title);
        $page->title = $request->title;
        $page->parent_id = $request->parent_id === 'null' ? null : $request->parent_id;
        $page->position = $request->position ?? 0;
        $page->content = $request['content'];
        $page->thumbnail = $request->thumbnail;
        $page->status = $request->status;
        $page->user_id = auth()->id();

        $storedSliders = [];
        $newSliders = $request->file('sliders_new', []);
        foreach ($newSliders as $file) {
            if ($file && $file->isValid()) {
                $storedSliders[] = $file->store('sliders', 'public');
            }
        }
        $page->sliders = json_encode($storedSliders);

        $page->save();

        return response()->json([
            'message' => 'Page created successfully',
            'data' => $page
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return inertia::render('PublicPages/PageEditor', [
            'page' => $page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdatePageRequest $request, Page $page)
    {

        $page->title = $request->title;
        $page->content = $request['content'];
        $page->thumbnail = $request->thumbnail;
        $page->status = $request->status ?? 'draft';

        $storedSliders = [];
        $existingSliders = $request->input('sliders_existing', []);
        foreach ($existingSliders as $slider) {
            $storedSliders[] = $slider;
        }
        $newSliders = $request->file('sliders_new', []);
        foreach ($newSliders as $file) {
            if ($file && $file->isValid()) {
                $storedSliders[] = $file->store('sliders', 'public');
            }
        }

        $page->sliders = json_encode($storedSliders);
        $page->save();
        $data = $page;

        return response()->json([
            'message' => 'Page updated successfully',
            'data' => $data
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function updatePageStatus(Request $request, $slug)
    {
        $request->validate([
            'status' => 'required|in:published,draft',
        ]);

        $page = Page::where('slug', $slug)->first();
        $page->status = $request->status;
        $page->save();
        return response()->json(['message'=> 'page updated successfully']);
    }
    public function destroy(Page $page)
    {
        //
    }
}
