<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role', // Ajout du champ "role" pour différencier les types d'utilisateurs
        'date_inscription',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mot_de_passe' => 'hashed',
        ];
    }

    /**
     * Relation : Utilisateur (employé) -> Tickets qu'il a créés.
     */
    public function ticketsCrees()
    {
        return $this->hasMany(Ticket::class, 'id_employe');
    }

    /**
     * Relation : Technicien -> Tickets qui lui sont assignés.
     */
    public function ticketsAssignes()
    {
        return $this->hasMany(Ticket::class, 'id_technicien');
    }

    /**
     * Méthode pour récupérer le mot de passe.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Vérifie si l'utilisateur a un rôle spécifique.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
       
        return $this->role === $role;
    }
}

