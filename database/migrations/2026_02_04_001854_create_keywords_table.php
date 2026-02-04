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
        // schema de la table keywords de france travail   
        Schema::create('keywords', function (Blueprint $table){
            $table->increments('id');
            $table->text('metiers')->nullable();
            $table->text('villes')->nullable();
            $table->timestamp('date_insertion');
            $table->text('updated_aat')->nullable();
            $table->boolean('statut')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('keywords');
    }
};
