<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $postData = Photo::all()->where('user_id' ,'!=', Auth::user()->id)->where('is_public', 1);

        return view('pages.dashboard', compact('postData'));
    }
}
