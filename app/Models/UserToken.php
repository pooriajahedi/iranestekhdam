<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','token'];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
        'expire_time',
    ];

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

}
