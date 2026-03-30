<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aqui definimos os endpoints da aplicação. O uso de Middlewares garante
| que apenas usuários autenticados acessem as áreas críticas do sistema.
*/

// Rota Pública
Route::get('/', function () {
    return redirect()->route('login');
});

// Área Autenticada
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard: Listagem simplificada com Eager Loading
    Route::get('/dashboard', function () {

        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'tickets' => auth()->user()
                ->tickets()
                ->with(['project.company', 'detail']) // 'detail' incluído para mostrar progresso
                ->latest()
                ->get()
        ]);
    })->name('dashboard');

    // Módulo de Perfil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Módulo de Tickets (CRUD Parcial)
    // Usamos prefix para evitar repetição de '/tickets'
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
    });

    
});

require __DIR__.'/auth.php';
