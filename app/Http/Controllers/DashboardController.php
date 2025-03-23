<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class DashboardController extends Controller
{


    public function index()
    {
        $tickets = Ticket::all(); // Récupère tous les tickets
        return view('dashboard', compact('tickets'));
    }

}