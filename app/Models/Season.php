<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;
    protected $fillable = ["title","course_id"];

    public function course(){
        return $this->belongsTo(Courses::class);
    }

    public function subseasons():HasMany{
        return $this->hasMany(Subseason::class,"season_id");
    }
}
