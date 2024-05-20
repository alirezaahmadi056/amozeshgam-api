<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $fillable = ["name","phone","birthday","email","merrid","gender","user_id","cup_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function cups(){
        return $this->hasMany(Cup::class);
    }
}
