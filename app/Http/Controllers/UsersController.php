<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    //
    public function index(){
        $users_All = User::all();
        return response()->json(['data'=> $users_All], 200);
    }

    public function show(User $id){
        return $id;
    }

    public function update(Request $request, User $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $id->update([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);
        
        return response()->json([
            'message' => 'Users edited!',
            'users' => $id
        ]);
    }

    public function destroy(User $id)
    {
        $id->delete();
        return response()->json([
            'message' => 'Users deleted'
        ]);
    }
}
