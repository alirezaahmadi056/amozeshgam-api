<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubFieldVideo extends Model
{
    use HasFactory;
    protected $fillable = ["video","sub_fields_id"];

    public function Subfield():BelongsTo{
        return $this->belongsTo(SubField::class);
    }
}
