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
        Schema::create('num_entreprise', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entreprise')->nullable();
            $table->string('telephone', length:32)->nullable();
            $table->string('place_id', length:64)->nullable();
            $table->timestamp('created_at')->default(now());
            $table->integer('row_lien')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('num_entreprise');
    }
};
