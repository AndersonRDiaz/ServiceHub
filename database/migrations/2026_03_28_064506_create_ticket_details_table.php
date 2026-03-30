<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_details', function (Blueprint $table) {
        $table->id(); 
        $table->foreignId('ticket_id')->unique()->constrained()->onDelete('cascade');
        $table->text('content');          // Armazena o texto bruto do anexo
        $table->json('metadata')->nullable(); // Armazena dados extras processados
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_details');
    }
};
