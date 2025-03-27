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
        return redirect()->route('administrateur'); // Rediriger vers la page d'administration
        
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
        $tickets = Ticket::where('id_technicien', $user->id)->get(); // Récupérer les tickets assignés au technicien
    
        return view('technicien', compact('tickets', 'user'));
    }
    public function administrateur()
    {
        $tickets = Ticket::all(); // Récupérer tous les tickets
        $users = User::all(); // Récupérer tous les utilisateurs
        $techniciens = User::where('role', 'technicien')->get(); // Récupérer uniquement les techniciens

         return view('administrateur', compact('tickets', 'users','techniciens'));
    }

    

}