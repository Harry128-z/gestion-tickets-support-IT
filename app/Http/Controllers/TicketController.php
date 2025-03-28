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
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:Ouvert,En cours,Résolu,Fermé',
            'priorité' => 'required|in:Faible,Moyenne,Élevée,Critique',
            'id_employe' => 'required|integer|exists:users,id',
            'id_technicien' => 'nullable|integer|exists:users,id',
        ]);
    
        Ticket::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'priorité' => $request->priorité,
            'statut' => $request->statut,
            'id_employe' => auth()->user()->id,
        ]);
    
        return redirect()->route('administrateur')->with('status', 'Le ticket a été créé avec succès!');
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
        $request->validate([
            'statut' => 'required|in:En cours,Résolu,Fermé',
            'actions' => 'nullable|string|max:1000', // Validation pour les actions
        ]);
    
        $ticket = Ticket::find($id);
    
        if (!$ticket || $ticket->id_technicien != auth()->user()->id) {
            return redirect()->back()->withErrors(['error' => 'Ticket introuvable ou non assigné à vous.']);
        }
    
        // Ajouter les actions effectuées à la description existante
        $newDescription = $ticket->description;
        if ($request->actions) {
            $newDescription .= "\n\nAction effectuée par le technicien (" . now()->format('d/m/Y H:i') . "):\n" . $request->actions;
        }
    
        // Mettre à jour le statut et la description du ticket
        $ticket->update([
            'statut' => $request->statut,
            'description' => $newDescription, // Mise à jour de la description avec les actions
        ]);
    
        return redirect()->back()->with('status', 'Le statut du ticket a été mis à jour avec succès.');
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


    public function ticketsTechnicien()
    {
        $tickets = Ticket::where('id_technicien', auth()->user()->id)
                     ->whereIn('statut', ['Ouvert', 'En cours'])
                     ->get();

        return view('technicien', compact('tickets'));
    }

    
    public function assignTechnician(Request $request, $id)
    {
        \Log::info('AssignTechnician appelé avec ID : ' . $id);

        $request->validate([
            'id_technicien' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->id_technicien = $request->id_technicien;
        $ticket->save();

        \Log::info('Technicien assigné avec succès au ticket ID : ' . $id);

        return redirect()->back()->with('status', 'Technicien assigné avec succès.');
    }

    
 
}



