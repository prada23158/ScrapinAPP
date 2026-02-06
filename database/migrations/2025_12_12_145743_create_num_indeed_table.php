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
        Schema::create('num_indeed', function (Blueprint $table) {
            $table->increments('id');
            $table->text('entreprise')->nullable();
            $table->text('telephone')->nullable();
            $table->text('place_id')->nullable();
            $table->text('adresse')->nullable();
            $table->integer('row_lien')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('num_indeed');
    }
};
