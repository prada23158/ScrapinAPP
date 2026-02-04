<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Symfony\Component\Clock\now;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('infossocieteFT', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('id_entreprise')->nullable();
            $table->text('entreprise')->nullable();
            $table->text('adresse1')->nullable();
            $table->text('adresse2')->nullable();
            $table->text('adresse3')->nullable();
            $table->text('phone1')->nullable();
            $table->text('phone2')->nullable();
            $table->text('phone3')->nullable();
            $table->text('email1')->nullable();
            $table->text('email2')->nullable();
            $table->text('email3')->nullable();
            $table->text('website1')->nullable();
            $table->text('website2')->nullable();
            $table->text('website3')->nullable();
            $table->timestamp('date_insertion')->default(now());
            $table->boolean('statut')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infossocieteFT');
    }
};
