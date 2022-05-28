<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

   protected $fillable=["state",
   "request_note",
   "request_time",
   "response_note",
   "response_time",
   



   
];



}
