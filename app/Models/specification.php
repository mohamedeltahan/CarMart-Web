<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specification extends Model
{
    use HasFactory;

    protected $fillable=["en_title","arabic_title","image_link","ar_specification_category","en_specification_category"];
}
