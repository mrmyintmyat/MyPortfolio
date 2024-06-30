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
        Schema::create('game_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name'); // To store the game name
            $table->text('description')->nullable(); // To store the description of the game
            $table->string('photo_link')->nullable(); // To store the game photo link
            $table->string('type'); // To store whether the game is Original or Mod
            $table->string('version'); // To store whether the game is Old or New version
            $table->string('status')->default('Pending'); // To track the status of the request
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_requests');
    }
};
