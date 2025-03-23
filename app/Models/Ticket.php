<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'statut', 'priorité', 'id_employe', 'id_technicien', 'date_creation','date_mise_a_jour'];

    public function employe()
    {
        return $this->belongsTo(User::class, 'id_employe');
    }
    
    public function technicien()
    {
        return $this->belongsTo(User::class, 'id_technicien');
    }
}

