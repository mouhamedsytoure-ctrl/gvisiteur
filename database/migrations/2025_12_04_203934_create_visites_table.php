<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visites', function (Blueprint $table) {
            $table->id(); // id int

            // Référence au client
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('cascade'); 
            // si on supprime un client, on supprime ses visites

            // Horaires
            $table->dateTime('date_arrivee');           // Heure d’arrivée
            $table->dateTime('date_sortie')->nullable(); // Heure de sortie (peut être null si en cours)

            // Détails de la visite
            $table->text('motif');                     // Motif de la visite
            $table->string('personne_rencontree');     // Agent rencontré

            // Statut
            $table->enum('statut', ['EN_COURS', 'TERMINEE'])
                  ->default('EN_COURS');

            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
