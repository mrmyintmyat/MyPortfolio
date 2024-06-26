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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('about');
            $table->string('size');
            $table->integer('post_status')->default(0);
            $table->string('online_or_offline');
            $table->string('category');
            $table->longText('downloads')->default([0, 0, 0, 0, 0, 0, 0, 0]);
            $table->longText('download_links')->json();
            $table->longText("image")->json();
            $table->text('logo');
            $table->text('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
