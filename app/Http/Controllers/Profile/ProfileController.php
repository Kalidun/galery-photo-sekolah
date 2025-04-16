<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $photoData = Photo::all()->where('user_id', Auth::user()->id);
        $profileData = Auth::user();
        
        return view('pages.profile.index', [
            'photoData' => $photoData,
            'profile_image' => $profileData->profile_image,
            'name' => $profileData->name
        ]);
    }
    public function deleteProfile(){
        try{
            $userData = Auth::user();
            Storage::disk('public')->delete('profile/' . $userData->profile_image);

            $userData->update([
                'profile_image' => null
            ]);

            return redirect()->route('profile.edit')->with('success', 'Profile image deleted successfully!');
        }catch(\Throwable $th){
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
