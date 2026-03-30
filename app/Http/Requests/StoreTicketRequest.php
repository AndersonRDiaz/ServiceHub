<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    // Determina se o usuário está autorizado a fazer esta requisição.
    // Para o desafio, manteremos como true, mas em um cenário real, 
    // aqui você implementaria a lógica de autorização (ex: verificar se o usuário tem permissão para criar tickets no projeto específico)
    public function authorize(): bool
    {
        return true;
    }

    // Regras de validação técnicas para os campos do formulário de criação de ticket
    // Garantem que os dados recebidos sejam do tipo e formato esperado, protegendo a aplicação contra dados malformados ou maliciosos
    public function rules(): array
    {
        return [
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'attachment'  => 'nullable|file|mimes:json,txt|max:2048',
        ];
    }
}