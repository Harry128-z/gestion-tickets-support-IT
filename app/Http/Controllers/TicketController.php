<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\HuggingFaceService;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'statut' => 'required|string|max:50',
            'priorité' => 'required|string|max:50',
            'id_employe' => 'nullable|integer',
            'id_technicien' => 'nullable|integer',
        ]);
    
        // Création du ticket
        Ticket::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'],
            'statut' => 'statut',
            'priorité' => $validated['priorité'],
            'id_employe' => $validated['id_employe'] ?? null,
            'id_technicien' => $validated['id_technicien'] ?? null
        ]);

        Ticket::create($validated);
        // Message de confirmation et redirection
        return redirect()->back()->with('status', 'Le ticket a été créé avec succès !');
    }
    

    public function show($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        return response()->json($ticket);
    }

    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        // Recherche du ticket
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        // Mise à jour du ticket
        $ticket->update([
            'title' => $request->title ?? $ticket->title,
            'status' => $request->status ?? $ticket->status,
        ]);

        return response()->json($ticket);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully']);
    }

    
    public function commentaires($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        return response()->json($ticket->commentaires);
    }
 
}



