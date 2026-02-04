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
        Schema::create('liens_scrappedFT', function (Blueprint $table) {
            $table->increments('id');
            $table->text('titre_offre')->nullable();
            $table->text('lien_offre')->nullable();
            $table->string('entreprise')->nullable();
            $table->string('telephone', length:20)->nullable();
            $table->string('keywords')->nullable();
            $table->timestamp('created_aat')->default(now());
            $table->string('updated_aat')->nullable();
            $table->boolean('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liens_scrappedFT');
    }
};
