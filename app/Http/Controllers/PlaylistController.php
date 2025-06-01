<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaylistRequest;
use App\Models\Playlist;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::withCount('tracks')->get();

        return Inertia::render('Playlist/Index', [
            'playlists' => $playlists,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tracks = Track::where('display', true)->get();

        return Inertia::render('Playlist/Create', [
            'tracks' => $tracks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlaylistRequest $request)
    {
        $tracks = Track::whereIn('uuid', $request->tracks)->where('display', true)->get();

        if ($tracks->count() !== count($request->tracks)) {
            throw ValidationException::withMessages(['tracks' => 'Tracks not found']);
        }

        $playlist = Playlist::create([
            'uuid' => Str::uuid(),
            'user_id' => $request->user()->id,
            'title' => $request->title,
        ]);

        $playlist->tracks()->attach($tracks->pluck('id'));

        return redirect()->route('playlists.show', ['playlist' => $playlist]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        return Inertia::render('Playlist/Show', [
            'playlist' => $playlist->load('tracks'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        $tracks = Track::where('display', true)->get();

        return Inertia::render('Playlist/Edit', [
            'playlist' => $playlist->load('tracks'),
            'tracks' => $tracks,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlaylistRequest $request, Playlist $playlist)
    {
        $tracks = Track::whereIn('uuid', $request->tracks)->where('display', true)->get();

        if ($tracks->count() !== count($request->tracks)) {
            throw ValidationException::withMessages(['tracks' => 'Tracks not found']);
        }

        $playlist->title = $request->title;
        $playlist->save();

        $playlist->tracks()->sync($tracks->pluck('id'));

        return redirect()->route('playlists.show', ['playlist' => $playlist]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->tracks()->detach();
        $playlist->delete();

        return redirect()->back();
    }
}
