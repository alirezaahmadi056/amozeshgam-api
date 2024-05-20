<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubField extends Model
{
    use HasFactory;
    protected $fillable = ["title","image","field_id","description","price","time"];

    public function Field():BelongsTo{
        return $this->belongsTo(Fields::class);
    }

    public function SubFieldVideo():HasMany{
        return $this->hasMany(SubFieldVideo::class,"sub_fields_id");
    }
}
