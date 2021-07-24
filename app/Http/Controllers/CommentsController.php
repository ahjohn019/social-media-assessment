<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comments;

class CommentsController extends Controller
{
    public function index(){
        $comments_All = Comments::all();
        return response()->json(['data'=> $comments_All], 200);
    }

    public function store(Request $request){
        //store Comments data 
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'posts_id' => 'required'
        ]);

        $comments_Store = Comments::create($request->all());

        
        return response()->json(['message'=> 'Comments created', 
        'data' => $comments_Store]);
    }

    public function show(Comments $id){
        return $id;
    }

    public function update(Request $request, Comments $id){
        $request->validate([
            'name' => 'required'
        ]);

        $id->update($request->all());
        
        return response()->json([
            'message' => 'Comments edited!',
            'comments' => $id
        ]);
    }

    public function destroy(Comments $id)
    {
        $id->delete();
        return response()->json([
            'message' => 'Comments deleted'
        ]);
    }
}
