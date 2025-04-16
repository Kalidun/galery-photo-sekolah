<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileSettingController extends Controller
{
    public function index(){
        $userData = Auth::user();
     
        return view('pages.profile.settings', [
            'name' => $userData->name,
            'email' => $userData->email
        ]);
    }
    public function updateName(Request $request){
        try{
            $request->validate([
               'name' => 'required|string|max:255',
                'email' => 'required|string|email|exists:users',
            ]);

            $user = Auth::user();

            DB::beginTransaction();

            User::where('id', $user->id)->update([
                'name' => $request->name
            ]);

            DB::commit();

            return redirect()->route('profile.settings')->with('success', 'Name updated successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updatePassword(Request $request){
        try {
            $request->validate([
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|string|min:8|same:password',
            ]);

            $user = Auth::user();

            DB::beginTransaction();

            User::where('id', $user->id)->update([
                'password' => bcrypt($request->password)
            ]);

            DB::commit();

            return redirect()->route('profile.settings')->with('success', 'Password updated successfully!');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy(Request $request){
        try{
            $user = Auth::user();

            $photos = Photo::where('user_id', $user->id)->get();
            foreach ($photos as $photo) {
                Storage::disk('public')->delete('images/' . $photo->image);
                $photo->delete();
            }

            DB::beginTransaction();

            User::where('id', $user->id)->delete();

            DB::commit();

            return redirect()->route('home')->with('success', 'Account deleted successfully!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
