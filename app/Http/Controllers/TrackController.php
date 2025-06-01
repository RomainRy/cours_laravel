<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::where('display', true)->get();

        return Inertia::render('Track/Index', [
            'tracks' => $tracks,
        ]);
    }

    public function create()
    {
        return Inertia::render('Track/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'artist' => ['required', 'string', 'min:5', 'max:50'],
            'display' => ['required', 'boolean'],
            'image' => ['nullable', 'file', 'extensions:jpg,pged,png,svg'],
            'music' => ['required', 'file', 'extensions:mp3,wav']
        ]);

        $uuid = Str::uuid();
        $musicPath = $request->music->storeAs('tracks/musics', $uuid . '.' . $request->music->extension());
        $imagePath = $request->image?->storeAs('tracks/images', $uuid . '.' . $request->image->extension());

        Track::create([
            'uuid' => $uuid,
            'title' => $request->title,
            'artist' => $request->artist,
            'display' => $request->display,
            'music' => $musicPath,
            'image' => $imagePath,
        ]);

        return redirect()->route('tracks.index');
    }

    public function edit(Track $track)
    {
        return Inertia::render('Track/Edit', [
            'track' => $track,
        ]);
    }

    public function update(Request $request, Track $track)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'artist' => ['required', 'string', 'min:5', 'max:50'],
            'display' => ['required', 'boolean'],
        ]);

        $track->title = $request->title;
        $track->artist = $request->artist;
        $track->display = $request->display;
        $track->save();

        return redirect()->route('tracks.index');
    }

    public function destroy(Track $track)
    {
        $track->delete();

        return redirect()->back();
    }
}
