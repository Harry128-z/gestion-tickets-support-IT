<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'statut' => $this->faker->randomElement(['Ouvert', 'En cours', 'Résolu', 'Fermé']),
            'priorité' => $this->faker->randomElement(['Faible', 'Moyenne', 'Élevée', 'Critique']),
            'date_creation' => now(),
            'date_mise_a_jour' => $this->faker->dateTimeThisYear,
            'id_employe' => User::inRandomOrder()->first()->id, 
            'id_technicien' => User::inRandomOrder()->first()->id,
        ];
    }
}

