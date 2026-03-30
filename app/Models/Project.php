<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Representa um Projeto vinculado a uma Empresa
class Project extends Model
{

    use HasFactory;

    // Atributos que permitem atribuição em massa
    protected $fillable = [
        'name',
        'description',
        'company_id'
    ];
    
    // Um projeto pertence obrigatoriamente a uma empresa
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Um projeto pode conter diversas solicitações de serviço (Tickets)
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
