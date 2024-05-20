<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Introvideos extends Model
{
    use HasFactory;
    protected $fillable = ["model_type","video"];
}
