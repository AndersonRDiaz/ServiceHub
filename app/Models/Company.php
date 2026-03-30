<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Representa uma Entidade/Empresa no ecossistema ServiceHub
class Company extends Model
{

    use HasFactory; // Para testes automatizados e Seeders
    
    // Atributos que permitem atribuição em massa (Mass Assignment)
    protected $fillable = [
        'name',
        'description'
    ];

    // Define o relacionamento de um para muitos (1:N) com Projetos
    // Uma empresa pode gerenciar múltiplos escopos de trabalho simultâneos
    public function projects()
    {
        // Uma empresa tem muitos projetos
        return $this->hasMany(Project::class);
        
    }
    
}
