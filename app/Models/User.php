<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'user_name', 'chat_id', 'last_name', 'email', 'phone_number', 'prefix_number', 'device_id', 'gender', 'state_id','password'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function AutomaticSelection()
    {
        return $this->hasOne('App\Models\UserAutomaticSubscription');
    }

    public function Search()
    {
        return $this->hasOne('App\Models\UserSearch', 'user_id');
    }

    public function Token()
    {
        return $this->hasOne('App\Models\UserToken', 'user_id');
    }

}
