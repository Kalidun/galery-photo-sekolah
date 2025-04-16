<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\PhotoComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request) {
        try{
            $request->validate([
                'comment' => 'required|string|max:255',
                'photo_id' => 'required|numeric|exists:photos,id',
            ]);

            $comment = PhotoComment::create([
                'comment' => $request->comment,
                'photo_id' => $request->photo_id,
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'success' => true,
                'posterImage' => auth()->user()->profile_image,
                'posterName' => auth()->user()->name,
                'photoDescription' => $comment->comment
            ], 200);
        } catch(\Throwable $th){
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }  
}
