<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileEditController extends Controller
{
    public function index()
    {
        $userData = Auth::user();

        return view('pages.profile.edit', [
            'name' => $userData->name,
            'bio' => $userData->bio,
            'gender' => $userData->gender,
            'birthday' => $userData->birthday,
            'profile_image' => $userData->profile_image
        ]);
    }

    public function update(Request $request){
        try{
            $request->validate([
                'profile_image' => 'nullable|image',
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'gender' => 'nullable|string',
                'birthday' => 'nullable|date',
            ]);
            
            $user = Auth::user();
            
            DB::beginTransaction();
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'bio' => $request->bio,
                'gender' => $request->gender,
                'birthday' => $request->birthday    
            ]);
            
            if ($request->profile_image) {
                $imageName = Auth::user()->name . '-' . time() . '.' . $request->profile_image->extension();
                Storage::disk('public')->delete('profile/' . $user->profile_image);
                $request->profile_image->storeAs('profile', $imageName, 'public');
                User::where('id', $user->id)->update([
                    'profile_image' => $imageName
                ]);
            }

            DB::commit();

            return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
