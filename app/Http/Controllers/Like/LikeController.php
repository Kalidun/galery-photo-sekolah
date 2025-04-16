<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'photo_id' => 'required|exists:photos,id'
        ]);
        $photo = Photo::find($request->photo_id);
        $photo->likes()->create([
            'user_id' => auth()->user()->id
        ]);
        return redirect()->back();
    }
    public function destroy(Request $request) {
        $request->validate([
            'photo_id' => 'required|exists:photos,id'
        ]);
        $photo = Photo::find($request->photo_id);
        $photo->likes()->where('user_id', auth()->user()->id)->delete();
        return redirect()->back();
    }
}
