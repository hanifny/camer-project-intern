<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EngineerResource;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function all() {
        $role = EngineerResource::collection(User::where('role_id', '2db7170e-7d23-4b16-98a0-095f4c3c1f6a')->get());
        return response()->json($role);
    }

    public function store(Request $request) {
        $engineer = new User;
        $engineer->nama = $request->nama;

        $engineer->password = bcrypt($request->password);
        $engineer->role_id = '2db7170e-7d23-4b16-98a0-095f4c3c1f6a';
        $engineer->save();
        return response()->json($engineer);
    }   


    public function changePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user = User::where('email', $request->email);
        $password = $user->first()->password;

        if (!(Hash::check($request->old_password, $password))) {
            // The passwords matches
            return response()->json(['message' => 'Your current password does not matches with the password you provided. Please try again.']);
        } else {
            $update = $user->update([
                'password' => bcrypt($request->password)
            ]);
            if ($update) {
                return response()->json(['status' => 'success']);
            }
        }
    }
}
