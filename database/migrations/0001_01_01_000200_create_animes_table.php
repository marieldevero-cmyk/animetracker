<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ghibli_animes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->integer('movie_year')->nullable();
            $table->string('genre')->nullable();
            $table->string('duration')->nullable();
            $table->string('current_status')->default('Watch List');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ghibli_animes');
    }
};
