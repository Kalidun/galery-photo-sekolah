<?php

namespace App\Http\Controllers\Photo;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $albumData = Album::where(function ($query) {
            $query->where('user_id', auth()->user()->id)
                ->orwhere('id', 1);
        })->get();

        return view('pages.photo.index',[
            'albumData' => $albumData,
        ]);
    }
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        $albumData = Album::where('user_id', auth()->user()->id)->get();
        return view('pages.photo.edit', ['photo' => $photo, 'albumData' => $albumData]);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'is_public' => 'required|in:0,1',
                'description' => 'required|string|max:255',
                'image' => 'required|image',
                'album_id' => 'nullable|numeric|exists:albums,id',
            ]);

            $imageName = Auth::user()->name . '-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');

            DB::beginTransaction();

            $photo = Photo::create([
                'user_id' => Auth::user()->id,
                'is_public' => $request->is_public,
                'description' => $request->description,
                'image' => $imageName,
            ]);

            if($request->has('album_id')) {
                $photo->album_id = $request->album_id;
                $photo->save();
            }

            DB::commit();

            return redirect()->route('profile.index')->with('success', 'Photo created successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function update(Request $request, $id){
        try{
            $request->validate([
                'is_public' => 'required|in:0,1',
                'description' => 'required|string|max:255',
                'image' => 'nullable|image',
                'album_id' => 'nullable|numeric|exists:albums,id',
            ]);

            $photo = Photo::findOrFail($id);
            $photo->is_public = $request->is_public;
            $photo->description = $request->description;

            if($request->has('album_id')) {
                $photo->album_id = $request->album_id;
            }

            if($request->hasFile('image')) {
                Storage::disk('public')->delete('images/' . $photo->image);
                $imageName = Auth::user()->name . '-' . time() . '.' . $request->image->extension();
                $request->image->storeAs('images', $imageName, 'public');
                $photo->image = $imageName;
            }
            $photo->save();
            return redirect()->route('album.index')->with('success', 'Photo updated successfully!');
        }catch(\Throwable $th){
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $photo = Photo::findOrFail($id);
            Storage::disk('public')->delete('images/' . $photo->image);
            $photo->delete();
            return redirect()->route('home')->with('success', 'Photo deleted successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
