<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Ticket;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user(); // Récupérer l'utilisateur connecté
    
        // Rediriger en fonction du rôle de l'utilisateur
        if ($user->role === 'Admin') {
            return redirect()->route('administrateur');
        } elseif ($user->role === 'Technicien') {
            return redirect()->route('technicien');
        } elseif ($user->role === 'Employé') {
            return redirect()->route('employe');
        }
            // Si le rôle n'est pas défini, afficher une erreur
        abort(403, 'Accès non autorisé');
    }

    public function employe()
    {
        $user = auth()->user(); // Utilisateur connecté
        $tickets = Ticket::where('id_employe', $user->id)->get(); // Récupérer les tickets créés par l'employé
    
        return view('employe', compact('tickets', 'user'));
    }
    
    public function technicien()
    {
        $user = auth()->user(); // Utilisateur connecté
        $tickets = Ticket::where('id_technicien', $user->id)
                         ->where('statut', '!=', 'Fermé') // Exclure les tickets fermés
                         ->get();
    
        return view('technicien', compact('tickets', 'user'));
    }

private function getTicketStatistics()
{
    $tickets = Ticket::all();

    // Calcul des statistiques
    return [
        'total_tickets' => $tickets->count(),
        'tickets_ouverts' => $tickets->where('statut', 'Ouvert')->count(),
        'tickets_resolus' => $tickets->where('statut', 'Résolu')->count(),
        'tickets_critiques' => $tickets->where('priorité', 'Critique')->count(),
        'temps_moyen_resolution' => $this->calculerTempsMoyenResolution(),
    ];
}

private function calculerTempsMoyenResolution()
{
    $tickets_resolus = Ticket::where('statut', 'Résolu')->get();

    if ($tickets_resolus->isEmpty()) {
        return 0; // Aucun ticket résolu
    }

    $total_temps = 0;
    foreach ($tickets_resolus as $ticket) {
        $total_temps += $ticket->updated_at->diffInHours($ticket->created_at);
    }

    return round($total_temps / $tickets_resolus->count(), 2); // Temps moyen en heures
}

public function administrateur()
{
    $user = auth()->user();

    // Vérifiez si l'utilisateur est un administrateur
    if ($user->role !== 'Admin') {
        abort(403, 'Accès non autorisé');
    }

    $tickets = Ticket::all(); // Récupérer tous les tickets
    $techniciens = User::where('role', 'Technicien')->get(); // Récupérer tous les techniciens
    $users = User::all(); // Récupérer tous les utilisateurs

    $statistiques = [
        'total_tickets' => $tickets->count(),
        'tickets_ouverts' => $tickets->where('statut', 'Ouvert')->count(),
        'tickets_resolus' => $tickets->where('statut', 'Résolu')->count(),
        'tickets_critiques' => $tickets->where('priorité', 'Critique')->count(),
        'temps_moyen_resolution' => $this->calculerTempsMoyenResolution(), // Ajout de la clé
    ];

    return view('administrateur', compact('tickets','users', 'techniciens', 'statistiques'));
}
}