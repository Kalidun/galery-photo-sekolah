<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $photoData = Photo::all()->where('user_id', Auth::user()->id);

        return view('pages.profile.index', compact('photoData'));
    }
}
