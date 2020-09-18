<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EngineerResource;
use App\User;

class UserController extends Controller
{
    public function all() {
        $role = EngineerResource::collection(User::where('role_id', '2db7170e-7d23-4b16-98a0-095f4c3c1f6a')->get());
        return response()->json($role);
    }

    public function store(Request $request) {
        $engineer = new User;
        $engineer->nama = $request->nama;
        $engineer->email = $request->email;
        $engineer->password = bcrypt($request->password);
        $engineer->role_id = '2db7170e-7d23-4b16-98a0-095f4c3c1f6a';
        $engineer->save();
        return response()->json($engineer);
    }   
}
