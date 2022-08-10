<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GCM extends Model
{
    use HasFactory;
    protected $fillable=['device_id','firebase_token'];
}
