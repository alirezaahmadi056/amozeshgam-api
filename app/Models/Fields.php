<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fields extends Model
{
    use HasFactory;
    protected $fillable = ["title","image","link"];

    public function SubFields():HasMany{
        return $this->hasMany(SubField::class,"field_id");
    }

    public function FieldVideos():HasMany{
        return $this->hasMany(FieldVideo::class,"field_id");
    }
}
