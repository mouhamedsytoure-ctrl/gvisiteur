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
        Schema::table('visites', function (Blueprint $table) {
            if (!Schema::hasColumn('visites', 'nom_visiteur')) {
                $table->string('nom_visiteur')->after('client_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visites', function (Blueprint $table) {
            if (Schema::hasColumn('visites', 'nom_visiteur')) {
                $table->dropColumn('nom_visiteur');
            }
        });
    }
};
