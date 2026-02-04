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
        Schema::create('prospectft', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_entreprise')->nullable();
            $table->text('entreprise')->nullable();
            $table->text('contact1')->nullable();
            $table->text('contact2')->nullable();
            $table->text('contact3')->nullable();
            $table->text('contact4')->nullable();
            $table->text('contact5')->nullable();
            $table->integer('row_lien')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospectft');
    }
};
