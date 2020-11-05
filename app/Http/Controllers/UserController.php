<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AdminEngineerResource;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function all() {
        $role = AdminEngineerResource::collection(User::orderBy('role_id', 'asc')->get());
        return response()->json($role);
    }

    public function store(Request $request) {
        $user = new User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($request->role == 'admin') {
            $user->role_id = '78e83712-9bfe-4bd2-9689-886324a48acb';
        } elseif ($request->role == 'engineer') {
            $user->role_id = '9db7170e-7d23-4b16-98a0-095f4c3c1f6a';
        }
        $user->save();
        return response()->json($user);
    }   

    public function update(Request $request) {
        $user = User::find($request->id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        if ($request->role == 'admin') {
            $user->role_id = '78e83712-9bfe-4bd2-9689-886324a48acb';
        } elseif ($request->role == 'engineer') {
            $user->role_id = '9db7170e-7d23-4b16-98a0-095f4c3c1f6a';
        } 
        $user->save();
        return response()->json($user);
    }

    public function destroy($id) {
        $user = User::find($id); 
        if ($user->role->nama != 'SuperAdmin') {
            $user->delete();
            return response()->json($user);
        } else {
            return response()->json(['status' => 'failed'], 422);
        }
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
