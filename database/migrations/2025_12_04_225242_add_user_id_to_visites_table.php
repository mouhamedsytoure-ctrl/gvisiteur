<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // n'ajoute que si la colonne n'existe pas encore
        if (! Schema::hasColumn('visites', 'user_id')) {
            Schema::table('visites', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('client_id');
            });

            // Ajout de la contrainte FK séparément (max de compatibilité)
            Schema::table('visites', function (Blueprint $table) {
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('visites', 'user_id')) {
            Schema::table('visites', function (Blueprint $table) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // ignore si la contrainte n'existe pas
                }
                $table->dropColumn('user_id');
            });
        }
    }
};