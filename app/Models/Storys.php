<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storys extends Model
{
    use HasFactory;
    protected $fillable = ["link","media","view_count","title"];
}
