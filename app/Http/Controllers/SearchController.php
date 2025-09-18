<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use function Termwind\render;


class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->get('q', '');
        $pages = collect();
        $projects = collect();

        if ($q) {
            $pages = Page::query()
                ->where('content', 'like', "%{$q}%")
                ->limit(5)
                ->get(['id', 'title', 'content', 'slug'])
                ->map(fn($page) => [
                    'id' => $page->id,
                    'type' => 'page',
                    'slug' => $page->slug,
                    'title' => $page->title,
                    'snippet' => str($page->content)->limit(100),
                ]);

            $projects = Project::query()
                ->with('page:id,slug') // only fetch slug from related page
                ->where('title', 'like', "%{$q}%")
                ->limit(5)
                ->get(['id', 'title', 'page_id'])
                ->map(fn($project) => [
                    'id' => $project->id,
                    'type' => 'project',
                    'slug' => optional($project->page)->slug, // safe access
                    'title' => $project->title,
                    'snippet' => null,
                ]);
        }

        $results = $pages->merge($projects)->values();

        // If AJAX, return JSON (for live search)
        if ($request->wantsJson()) {
            return response()->json(['results' => $results]);
        }

        // If direct page load
        return inertia('SearchPage', [
            'results' => $results,
            'q' => $q
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
