<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Commentaire;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
       
        \App\Models\User::factory(10)->create();

        \App\Models\Ticket::factory(20)->create();

        \App\Models\Commentaire::factory(50)->create();
    }
}
