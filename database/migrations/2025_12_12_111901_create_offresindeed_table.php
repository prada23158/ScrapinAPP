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
        Schema::create('offresindeed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('poste')->nullable();
            $table->string('entreprise')->nullable();  
            $table->string('lieu')->nullable();  
            $table->string('contrat')->nullable();  
            $table->string('page_URL')->nullable();  
            $table->string('societe')->nullable();  
            $table->string('row_lien')->nullable();  
            $table->timestamp('date_insertion');
            $table->boolean('statut')->default(0);  
            $table->boolean('num_scrapped')->default(0);  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('offresindeed');
    }
};
