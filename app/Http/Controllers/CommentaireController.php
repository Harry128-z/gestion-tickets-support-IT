<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'user_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
        ]);

        $commentaire = Commentaire::create($request->all());

        return response()->json($commentaire, 201);
    }

    public function show($ticketId)
    {
        return Commentaire::where('ticket_id', $ticketId)->get();
    }
}

