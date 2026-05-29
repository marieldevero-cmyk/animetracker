<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimeController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->animes();

        if ($request->filled('status')) {
            $query->where('current_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%");
            });
        }

        $animes = $query->latest()->paginate(10);

        return view('anime.index', compact('animes'));
    }

    public function favorites()
    {
        $animes = auth()->user()->animes()
            ->where('current_status', 'Favorite')
            ->latest()
            ->get();

        return view('anime.favorites', compact('animes'));
    }

    public function watchList()
    {
        $animes = auth()->user()->animes()
            ->where('current_status', 'Watch List')
            ->latest()
            ->get();

        return view('anime.watch-list', compact('animes'));
    }

    public function watched()
    {
        $animes = auth()->user()->animes()
            ->where('current_status', 'Watched')
            ->latest()
            ->get();

        return view('anime.watched', compact('animes'));
    }

    public function show(Anime $anime)
    {
        if ($anime->user_id !== auth()->id()) {
            abort(403);
        }

        return view('anime.show', compact('anime'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'movie_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'genre' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'japanese_name' => ['nullable', 'string', 'max:255'],
            'director' => ['nullable', 'string', 'max:255'],
            'poster' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'current_status' => ['required', 'in:Watch List,Watched,Favorite'],
        ]);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', config('filesystems.cloud_images', 'public'));
        }

        auth()->user()->animes()->create($data);

        return redirect()->back()->with('success', 'Anime added successfully.');
    }

    public function edit(Anime $anime)
    {
        if ($anime->user_id !== auth()->id()) {
            abort(403);
        }

        return view('anime.edit', compact('anime'));
    }

    public function update(Request $request, Anime $anime)
    {
        if ($anime->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'movie_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'genre' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'synopsis' => ['nullable', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:10'],
            'japanese_name' => ['nullable', 'string', 'max:255'],
            'director' => ['nullable', 'string', 'max:255'],
            'poster' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'current_status' => ['required', 'in:Watch List,Watched,Favorite'],
        ]);

        $disk = config('filesystems.cloud_images', 'public');

        if ($request->hasFile('poster')) {
            if ($anime->poster) {
                Storage::disk($disk)->delete($anime->poster);
            }

            $data['poster'] = $request->file('poster')->store('posters', $disk);
        }

        $anime->update($data);

        return redirect()->route('anime.index')->with('success', 'Anime updated successfully.');
    }

    public function destroy(Anime $anime)
    {
        if ($anime->user_id !== auth()->id()) {
            abort(403);
        }

        if ($anime->poster) {
            Storage::disk(config('filesystems.cloud_images', 'public'))->delete($anime->poster);
        }

        $anime->delete();

        return redirect()->back()->with('success', 'Anime deleted successfully.');
    }
}
