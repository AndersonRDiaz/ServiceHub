<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function detail()
    {
        // Um Ticket tem um Detalhe Único
        return $this->hasOne(TicketDetail::class);
    }

    public function project()
    {
        // Um Ticket pertence a um Projeto
        return $this->belongsTo(Project::class);
    }
}
