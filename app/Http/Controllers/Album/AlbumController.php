<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albumData = Album::where(function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();

        return view('pages.album.index', [
            'albumData' => $albumData
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            Album::create([
                'user_id' => auth()->user()->id,
                'name' => $request->name,
            ]);
            return redirect()->route('album.index')->with('success', 'Album created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function read($id){
        try{
            $album = Album::findOrFail($id);
            $photos = Photo::where('album_id', $album->id)->get();

            return view('pages.album.detail', [
                'photos' => $photos,
                'album_name' => $album->name
            ]);
        } catch(\Throwable $th){
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function allPhotos(){
        try{
            $photos = Photo::where('user_id', auth()->user()->id)->get();
            return view('pages.album.detail', [
                'photos' => $photos,
                'album_name' => 'Semua Foto'
            ]);
        }catch(\Throwable $th){
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
