<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('match_id')->nullable(false);
            $table->integer('seat_id')->nullable(false);
            $table->enum('status',['available','booked','canceled'])->default('available');
            $table->integer('user_id')->default(NULL);
            $table->dateTime('booked_at')->default(NULL);
            $table->string('payment_method',50);
            $table->timestamps();

            $table->foreignId('match_id')->references('id')->on('matches');
            $table->foreignId('seat_id')->references('id')->on('seats');
            $table->foreignId('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
