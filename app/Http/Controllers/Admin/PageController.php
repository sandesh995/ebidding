<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\MediaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:190'],
            'body'  => ['required'],
            'slug'  => ['required', 'unique:pages,slug'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif'],
        ]);

        if ($request->hasFile('image')) {
            $data['media_id'] = (new MediaService)->upload($request->file('image'), "pages");
        }

        // unset($data['image']);

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'New Page added successfully!');
    }

    public function show(Page $page): View
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:190'],
            'body'  => ['required'],
            'slug'  => ['required', 'unique:pages,slug,' . $page->id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif'],
        ]);

        if ($request->hasFile('image')) {
            if ($page->media_id && $page->media) {
                Storage::delete('public/' . $page->media->path);
            }
            $data['media_id'] = (new MediaService)->upload($request->file('image'), "pages");
        }

        // unset($data['image']);

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page): RedirectResponse
    {

        if ($page->media_id && $page->media) {
            Storage::delete('public/' . $page->media->path);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully!');
    }
}