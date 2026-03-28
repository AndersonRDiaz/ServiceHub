<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketDetail extends Model
{
    public function ticket()
    {
        // Um detalhe pertence a um Ticket
        return $this->belongsTo(Ticket::class);
    }
}
