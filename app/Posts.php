<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'likes','user_id'
    ];

    public function users()  
    {  
        return $this->belongsTo('App\User','user_id');  
    }  

}
