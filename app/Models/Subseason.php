<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subseason extends Model
{
    use HasFactory;
    protected $fillable = ["title","time","season_id"];

    public function season():BelongsTo{
        return $this->belongsTo(Season::class);
    }
}
