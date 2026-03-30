<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

// Job assíncrono para processamento de anexos de tickets
// Extrai o conteúdo bruto de arquivos (TXT/JSON) e enriquece o TicketDetail
class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Número de vezes que o job será tentado em caso de falha, tentará processar novamente o arquivo antes de marcar como falha definitiva
    public int $tries = 3;

    // $ticket Instância serializada do ticket a ser processado
    // $filePath Caminho do anexo no storage
    public function __construct(
        public Ticket $ticket, // Agora ele aceita o objeto enviado pela Controller
        public string $filePath
    ) {}

    // Processa o anexo e enriquece o detalhe técnico do ticket
    public function handle(): void {

        // Verificamos apenas se ele ainda existe (caso tenha sido deletado da fila até o processamento)
        if (!$this->ticket->exists) {
            return;
        }

        // Ajuste o disco se necessário para storage/app
        if (!Storage::exists($this->filePath)) {
            $this->ticket->update(['status' => 'FAILED_FILE_NOT_FOUND']);
            return;
        }

        // Obtém o conteúdo do arquivo (pode ser texto ou JSON, dependendo do tipo)
        $fileContent = Storage::get($this->filePath);

        // Enriquecimento do TicketDetail (1:1) - Atualiza ou cria o detalhe técnico do ticket
        // O conteúdo do arquivo é salvo no campo 'content' e, se for JSON, é decodificado e salvo em 'metadata'
        $this->ticket->detail()->updateOrCreate(
            ['ticket_id' => $this->ticket->id],
            [
                'content' => $fileContent,
                'metadata' => str_ends_with($this->filePath, '.json') 
                            ? json_decode($fileContent, true) 
                            : []
            ]
        );

        $this->ticket->update(['status' => 'PROCESSED']);
    }
}