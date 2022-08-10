<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanksHiring extends Model
{
    use HasFactory;

    protected $fillable=["title","link",'guid','description'];
}
