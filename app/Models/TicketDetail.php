<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Armazena informações técnicas detalhadas de um Ticket
// Geralmente populado por processos em fila (Jobs) após a leitura de anexos
class TicketDetail extends Model
{
    use HasFactory;

    // Campos para inserção
    protected $fillable = [
        'ticket_id',
        'content',      // Onde vamos salvar o texto do arquivo
        'metadata',     // Para salvar dados processados JSON
    ];

    // Conversão de tipos de atributos para facilitar o uso no PHP
    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }

    // Relação inversa 1:1 com o Ticket
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
