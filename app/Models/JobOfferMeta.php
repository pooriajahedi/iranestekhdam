<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOfferMeta extends Model
{
    use HasFactory;

    protected $fillable = ['job_offer_id', 'value'];
    protected $hidden=['id','job_offer_id','value','created_at','updated_at'];
    public function jobOffer()
    {
        return $this->belongsTo('App\Models\JobOffer');
    }
}
