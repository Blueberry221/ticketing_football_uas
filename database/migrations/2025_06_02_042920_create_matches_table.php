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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('home_team')->nullable(false);
            $table->unsignedBigInteger('away_team')->nullable(false);
            $table->dateTime('match_date');
            $table->enum('status',['upcoming','ongoing','completed'])->nullable(false);
            $table->timestamps();

            $table->foreignId('home_team')->references('id')->on('teams');
            $table->foreignId('away_team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
