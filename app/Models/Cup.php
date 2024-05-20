<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    use HasFactory;
    protected $fillable = ["title","level","user_infos"];

    public function userInfo(){
        return $this->belongsTo(UserInfo::class);
    }
}
