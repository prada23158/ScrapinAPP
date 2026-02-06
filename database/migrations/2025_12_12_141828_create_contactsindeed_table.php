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
        Schema::create('contactsindeed', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('id_entreprise');
            $table->text('entreprise');
            $table->string('contact1')->nullable();
            $table->string('contact2')->nullable();
            $table->string('contact3')->nullable();
            $table->string('contact4')->nullable();
            $table->string('contact5')->nullable();
            $table->timestamp('date_insertion')->default(now());
            $table->boolean('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('contactsindeed');
    }
};
