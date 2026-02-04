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
        //
        Schema::create('offresFT', function (Blueprint $table) {
            $table->id();
            $table->string('Poste');
            $table->string('entreprise')->nullable();  
            $table->string('Lieu')->nullable();  
            $table->string('Contrat')->nullable();  
            $table->string('Page_URL')->nullable();  
            $table->string('row_lien')->nullable();  
            $table->string('status')->nullable();  
            $table->string('num_scrapped')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('offresFT');
    }
};
