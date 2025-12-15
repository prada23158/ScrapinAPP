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
        Schema::create('num_entreprise', function (Blueprint $table) {
            $table->id();
            $table->string('entreprise')->nullable();
            $table->string('telephone')->nullable();
            $table->string('place_id')->nullable();
            $table->string('row_lien')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('num_entreprise');
    }
};
