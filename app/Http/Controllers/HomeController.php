<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $postData = Photo::all()->where('is_public', 1);
        return view('pages.dashboard', compact('postData'));
    }

    public function getData($photoId)
    {
        try {
            $photo = Photo::findOrFail($photoId);

            return response()->json([
                'success' => true,
                'photoId' => $photo->id,
                'photoPath' => $photo->image,
                'photoDescription' => $photo->description,
                'photoCreatedAt' => $photo->created_at->diffForHumans(),
                'posterName' => $photo->user->name,
                'posterImage' => $photo->user->profile_image,
                'comments' => $photo->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'comment' => $comment->comment,
                        'commented_at' => $comment->created_at->diffForHumans(),
                        'posterImage' => $comment->user->profile_image,
                        'posterName' => $comment->user->name,
                    ];
                }),

                'likeData' => $photo->likes,
                'likeCount' => $photo->likes->count(),
                'isLiked' => $photo->likes->where('user_id', Auth::user()->id)->count() > 0 ? true : false,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
