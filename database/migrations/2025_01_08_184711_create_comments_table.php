<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Klucz obcy do tabeli posts
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Klucz obcy do tabeli users
            $table->string('title')->nullable(); // Tytuł komentarza
            $table->text('text'); // Treść komentarza
            $table->timestamps();
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
