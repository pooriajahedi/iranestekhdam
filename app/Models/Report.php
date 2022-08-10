<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable=['device_id','description','job_offer_id','title'];

    public function jobOffer()
    {
        return $this->belongsTo('App\Models\JobOffer','job_offer_id');
    }
}
