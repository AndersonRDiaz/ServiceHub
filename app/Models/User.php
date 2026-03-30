<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    // Essencial para segurança, evitando que campos sensíveis sejam alterados via formulário
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Atributos que devem ser ocultados em respostas JSON/Array
    // Garante que dados sensíveis como senhas não vazem para o Frontend
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casts de atributos para tipos nativos do PHP
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', 
        ];
    }
    
    // Perfil adicional do usuário (1:1)
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    // Tickets criados pelo usuário (1:N)
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
