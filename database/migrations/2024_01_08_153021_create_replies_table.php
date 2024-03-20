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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->longText('text');
            $table->unsignedBigInteger('likes')->default(0);
            $table->text('from_user_id');
            $table->text('to_user_id');
            $table->unsignedBigInteger('post_id');
            $table->text('reply_to')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
