<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model {

    use HasFactory;

    // Armazenamos o ID do usuário, telefone e cargo (position)
    // Campos para atribuição em massa.
    protected $fillable = ['user_id',
                'phone',
                'position'
    ];

    // Relacionamento inverso 1:1 com User, indicando que este perfil pertence a um único usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}