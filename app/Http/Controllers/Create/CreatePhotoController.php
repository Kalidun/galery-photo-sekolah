<?php

namespace App\Http\Controllers\Create;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreatePhotoController extends Controller
{
    public function index()
    {
        return view('pages.create.index');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'is_public' => 'required|in:0,1',
                'description' => 'required|string|max:255',
                'categories' => 'required|array|min:1',
                'categories.*' => 'string|max:50',
                'image' => 'required|image',
            ]);
            
            $imageName = Auth::user()->name . '-' . time() . '.' . $request->image->extension();
            $request->image->storeAs('images', $imageName, 'public');

            DB::beginTransaction();

            Photo::create([
                'user_id' => Auth::user()->id,
                'is_public' => $request->is_public,
                'description' => $request->description,
                'image' => $imageName,
                'categories' => json_encode($request->categories),
            ]);

            DB::commit();

            return redirect()->route('home')->with('success', 'Photo created successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
