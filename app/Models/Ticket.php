<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable=['user_id','ticket_category_id','subject','body','status','priority','device_id','is_read'];

    public function category()
    {
        return $this->belongsTo('App\Models\TicketCategory','ticket_category_id');
    }
    public function reply()
    {
        return $this->hasMany('App\Models\TicketAnswer');
    }
}
