<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;

// Route de la page d'accueil
Route::get('/', function () {
    $tickets = Ticket::all();
    return view('welcome', compact('tickets'));
});

// Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Groupement des routes pour les tickets (avec middleware auth pour les actions sécurisées)
Route::prefix('tickets')->middleware('auth')->group(function () {
    Route::get('/', [TicketController::class, 'index']); // Liste des tickets
    Route::get('/{id}', [TicketController::class, 'show']); // Voir un ticket spécifique
    Route::post('/', [TicketController::class, 'store']); // Créer un nouveau ticket
    Route::put('/{id}', [TicketController::class, 'update']); // Mettre à jour un ticket
    Route::delete('/{id}', [TicketController::class, 'destroy']); // Supprimer un ticket
    Route::post('/tickets', [TicketController::class, 'store']);



    // Routes pour les commentaires d'un ticket
    Route::get('/{ticketId}/commentaires', [TicketController::class, 'commentaires']); // Voir commentaires
    Route::post('/{ticketId}/commentaires', [TicketController::class, 'ajouterCommentaire']); // Ajouter un commentaire
    Route::delete('/{ticketId}/commentaires/{commentaireId}', [TicketController::class, 'supprimerCommentaire']); // Supprimer un commentaire

    // Demande liée à un ticket spécifique
    Route::post('/{ticketId}/ask', [TicketController::class, 'askQuestion']);
});

// Routes pour la gestion du profil utilisateur (protégées par middleware auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Voir formulaire d'édition du profil
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Mettre à jour le profil
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Supprimer le profil
});


// Inclusion des routes liées à l'authentification
require __DIR__.'/auth.php';