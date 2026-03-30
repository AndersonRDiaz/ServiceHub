<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ticket;
use App\Jobs\ProcessTicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTicketRequest; 

// Gerencia o ciclo de vida inicial de um Ticket de Serviço
class TicketController extends Controller
{

    // Lista projetos para o formulário de criação de ticket
    public function create(): Response
    {
        return Inertia::render('Tickets/Create', [
            // select() melhora a performance ao buscar apenas o necessário
            'projects' => Project::select('id', 'name')->get()
        ]);
    }

    // Persiste o Ticket e despacha processamento assíncrono
    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($request, $validated) {
            $ticket = Ticket::create([
                ...$validated,
                'user_id' => auth()->id(),
                'status'  => $request->hasFile('attachment') ? 'IN_PROCESSING' : 'OPEN',
            ]);

            if ($request->hasFile('attachment')) {
                // Armazenamento em disco privado por segurança
                $path = $request->file('attachment')->store('attachments');
                
                // Job despachado apenas após o commit do banco
                ProcessTicketAttachment::dispatch($ticket, $path)->afterCommit();
            }

            return redirect()->route('dashboard')->with('message', 'Ticket criado com sucesso!');
        }); 
    }

    // Exibe detalhes com proteção de acesso e Eager Loading
    public function show(Ticket $ticket): Response
    {
        // Uso de Policy $this->authorize('view', $ticket);
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket->load(['project.company', 'detail', 'user'])
        ]);
    }
}