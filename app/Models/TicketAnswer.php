<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAnswer extends Model
{
    use HasFactory;
    protected $fillable=["ticket_id","text","type"];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket','ticket_id');
    }
}
