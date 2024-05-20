<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courses extends Model
{
    use HasFactory;
    protected $fillable = ["image","title","time","teacher","status","rate","description","price","percent","spot_id"];

    public function comments():HasMany{
        return $this->hasMany(Comments::class,"course_id");
    }

    public function seasons(){
        return $this->hasMany(Season::class,"course_id");
    }
}
