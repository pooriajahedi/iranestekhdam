<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $hidden=['id','created_at','updated_at'];
    protected $fillable=["company_id","name","content","category","user_count","area","website","logo"];
}
