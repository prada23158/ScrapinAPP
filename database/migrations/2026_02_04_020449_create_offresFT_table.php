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
        Schema::create('offresFT', function (Blueprint $table) {
            $table->increments('idoffresFT');
            $table->text('Poste')->nullable();
            $table->bigInteger('idsociete')->unique()->nullable();
            $table->string('entreprise')->nullable();
            $table->string('Lieu', length:45)->nullable();
            $table->string('Contrat')->nullable();
            $table->string('Heure_de_travail', length:45)->nullable();
            $table->string('salaire_brut', length:45)->nullable();
            $table->integer('nombre_de_salarie')->nullable();
            $table->string('Description')->nullable();
            $table->string('Page_URL')->nullable();
            $table->text('row_lien')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('num_scrapped')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offresFT');
    }
};
