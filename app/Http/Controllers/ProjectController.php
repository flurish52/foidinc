<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $cards = Project::orderBy('created_at', 'DESC')->with('page')->get();
        return response()->json(['cards' => $cards]);
    }
    public function dailyReadings()
    {
        $url = 'https://bible.usccb.org/readings.rss';
        $rss = simplexml_load_file($url);
        $items = [];

        foreach ($rss->channel->item as $item) {
            $items[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'pubDate' => (string) $item->pubDate,
                'description' => (string) $item->description,
            ];
        }

        return response()->json($items);
    }

    public function newsFromVatican()
    {
        $feedUrl = 'https://cruxnow.com/feed'; // adjust to Vatican category feed if needed
        $feed = simplexml_load_file($feedUrl, 'SimpleXMLElement', LIBXML_NOCDATA);

        $news = [];
        foreach ($feed->channel->item as $item) {
            $namespaces = $item->getNameSpaces(true);

            // Thumbnail from <media:content>
            $thumbnail = null;
            if (isset($namespaces['media'])) {
                $media = $item->children($namespaces['media']);
                if (isset($media->content)) {
                    $thumbnail = (string)$media->content->attributes()->url;
                }
            }

            // Fallback: extract first <img> from content:encoded
            if (!$thumbnail && isset($namespaces['content'])) {
                $content = (string)$item->children($namespaces['content'])->encoded;
                if (preg_match('/<img[^>]+src="([^">]+)"/i', $content, $matches)) {
                    $thumbnail = $matches[1];
                }
            }

            $news[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'author' => isset($item->children('dc', true)->creator) ? (string) $item->children('dc', true)->creator : null,
                'pubDate' => (string) $item->pubDate,
                'description' => (string) $item->description,
                'thumbnail' => $thumbnail,
            ];
        }

        return response()->json($news);
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'page_id' => 'required|exists:pages,id',
            'thumbnail' => 'nullable|image|max:2048',
        ]);
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('project_thumbnails', 'public');
        }

         Project::updateOrCreate(
                ['id' => $cardData['id'] ?? null],
                [
                    'title' => $request->title,
                    'page_id' => $request->page_id,
                    'thumbnail' => $thumbnailPath ?? $request->thumbnail?? null
                ]
            );

        $cards = Project::orderBy('created_at', 'DESC')->with('page')->get();
        return response()->json(['message' => 'Cards saved successfully', 'cards' => $cards]);
    }

    // Delete a single card
    public function destroy(Project $card)
    {
        if ($card->thumbnail) {
            Storage::disk('public')->delete($card->thumbnail);
        }
        $card->delete();

        return response()->json(['message' => 'Card deleted']);
    }
}
