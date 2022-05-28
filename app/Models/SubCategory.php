<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'ar_title',
        'en_title',
        'photo_link',
        'ar_description',
        'en_description',
        'icon',
        'category_id'
 
    ];
}
