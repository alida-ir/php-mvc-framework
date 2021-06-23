<?php namespace App\Models;
use \config\Model;

class User extends Model
{
    protected $table = "users";
    
    protected $fillable = [
        "name" , "email"
    ];

    public function profile(){
//        return $this->belongsTo();
//        return $this->belongsToMany();
//        return $this->hasOne();
//        return $this->hasMany(); & ...
    }
}