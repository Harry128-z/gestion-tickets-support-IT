<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Trouve l'utilisateur ou retourne une erreur 404

        // Vérifie que l'utilisateur n'est pas un administrateur
        if ($user->role === 'administrateur') {
            return redirect()->back()->withErrors(['error' => 'Vous ne pouvez pas supprimer un administrateur.']);
        }

        $user->delete(); // Supprime l'utilisateur

        return redirect()->back()->with('status', 'Utilisateur supprimé avec succès.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Technicien,Employé',
        ]);

        User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'role' => $request->role,
            'mot_de_passe' => bcrypt('password123'), // Mot de passe par défaut
            'date_inscription' => now(), // Date d'inscription actuelle
        ]);

        return redirect()->back()->with('status', 'Utilisateur ajouté avec succès.');
    }
}