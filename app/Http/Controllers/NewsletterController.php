<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::orderBy('created_at', 'desc')->get();

        return inertia('Newsletters/DynamicPage', [
            'newsletters' => $newsletters
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'page_id' => 'required|exists:pages,id',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('file')->store('newsletters', 'public');

        Newsletter::create([
            'title' => $data['title'],
            'page_id' => $data['page_id'],
            'file_path' => $path,
        ]);

        return redirect()->route('admin.create_newsletter')
            ->with('success', 'Newsletter uploaded successfully');
    }









}
