<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOfferSubmitRequest extends Model
{
    use HasFactory;
    protected $fillable=["user_id","title","text","file_name","email","mobile_number","phone_number","status",'device_id'];
}
