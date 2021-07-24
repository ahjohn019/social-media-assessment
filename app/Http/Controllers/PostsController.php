<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    //
    public function index(){
        return $this->user->posts()->get();
        // $posts_All = Posts::all();
        // return response()->json(['data'=> $posts_All], 200);
    }

    public function store(Request $request){
        //store Posts data 
        $data = $request->only('name', 'description');
        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required'
        ]);

         //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $posts_Store = $this->user->posts()->create($request->all());

        return response()->json(['message'=> 'Posts created', 
        'Data' => $posts_Store]);   
    }

    public function show(Posts $id){
        return $id;
    }

    public function update(Request $request, Posts $id){
        //store Posts data 
        $data = $request->only('name', 'description');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update posts
        $product = $id->update([
            'name' => $request->name,
            'description' => $request->description,
            'likes' => $request->likes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);

        // $request->validate([
        //     'name' => 'required',
        //     'description' => 'required'
        // ]);

        // $id->update($request->all());
        
        // return response()->json([
        //     'message' => 'Posts edited!',
        //     'posts' => $id
        // ]);
    }

    public function destroy(Posts $id)
    {
        $id->delete();
        return response()->json([
            'message' => 'Posts deleted'
        ]);
    }

}
