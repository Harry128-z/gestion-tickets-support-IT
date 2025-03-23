<?php

namespace Database\Factories;

use App\Models\Commentaire;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaireFactory extends Factory
{
    protected $model = Commentaire::class;

    public function definition()
    {
        return [
            'ticket_id' => Ticket::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'contenu' => $this->faker->paragraph,
        ];
    }
}

