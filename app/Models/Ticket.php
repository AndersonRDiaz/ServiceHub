<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Entidade central para gestão de Ordens de Serviço
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',          // Importante para o ciclo de vida do ticket
        'attachment_path', // Adicionado para suportar o requisito de upload
        'project_id',
        'user_id',         // O autor do ticket
    ];

    // Cada ticket possui um detalhe técnico único (1:1)
    public function detail(): HasOne{
        return $this->hasOne(TicketDetail::class);
    }

    // O ticket está vinculado a um projeto (N:1)
    public function project(): BelongsTo{
        return $this->belongsTo(Project::class);
    }

    // O autor do ticket (N:1)
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    
    protected function status(): Attribute{
        return Attribute::make(
            get: fn (string $value) => strtoupper($value), // Sempre retorna MAIÚSCULO para o Vue
            set: fn (string $value) => strtoupper($value), // Sempre salva MAIÚSCULO no banco
        );
    }
}
