<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Identifiant unique du ticket
            $table->string('titre'); // Titre du problème
            $table->text('description'); // Description détaillée
            $table->enum('statut', ['Ouvert', 'En cours', 'Résolu', 'Fermé'])->default('Ouvert'); // État du ticket
            $table->enum('priorité', ['Faible', 'Moyenne', 'Élevée', 'Critique'])->default('Moyenne'); // Urgence
            $table->timestamp('date_creation')->useCurrent(); // Date de création automatique
            $table->timestamp('date_mise_a_jour')->nullable(); // Dernière modification
            $table->unsignedBigInteger('id_employe'); // Relation avec la table users
            $table->unsignedBigInteger('id_technicien')->nullable(); // Technicien assigné
            $table->foreign('id_employe')->references('id')->on('users')->onDelete('cascade'); // Clé étrangère cascade
            $table->foreign('id_technicien')->references('id')->on('users')->onDelete('cascade'); // Clé étrangère cascade
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}


