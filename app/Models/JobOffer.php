<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['title', 'content', 'apply_link', 'cats', 'company_description', 'company_logo', 'company_name', 'district', 'introduction', 'link', 'payamak', 'plan', 'state', 'time_detail'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function meta()
    {
        return $this->hasMany('App\Models\JobOfferMeta');
    }

    public function contact()
    {
        return $this->hasOne('App\Models\JobOfferContact');
    }
}
