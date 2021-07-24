<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $fillable = [
        'name', 'likes','user_id','posts_id'
    ];

    public function users()  
    {  
        return $this->belongsTo('App\User', 'user_id');  
    }  

    public function posts()  
    {  
        return $this->belongsTo('App\Posts', 'posts_id');   
    }  

}
