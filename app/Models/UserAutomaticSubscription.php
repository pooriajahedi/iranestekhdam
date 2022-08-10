<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAutomaticSubscription extends Model
{
    use HasFactory;
    protected $fillable=['user_id','state_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function state($id)
    {

        return CtegoriesCombination::find($id);
    }
}
