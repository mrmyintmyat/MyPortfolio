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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('from_user_id');
            $table->text('to_user_id');
            $table->longText('text');
            $table->text('likes')->default(0);
            $table->unsignedBigInteger('post_id');
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
