<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOfferContact extends Model
{
    use HasFactory;

    protected $fillable = ['job_offer_id',
        'email',
        'address',
        'phone',
        'sms',
        'whatsapp',
        'telegram',
        'website',
        'fax',
        'postalCode',
        'registerLink'
    ];

    protected $hidden=['id','created_at','updated_at','job_offer_id'];
}
