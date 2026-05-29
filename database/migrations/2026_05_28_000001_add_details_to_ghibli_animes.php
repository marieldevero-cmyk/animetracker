<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ghibli_animes', function (Blueprint $table) {
            $table->text('synopsis')->nullable()->after('duration');
            $table->decimal('rating', 3, 1)->nullable()->after('synopsis');
            $table->string('japanese_name')->nullable()->after('rating');
            $table->string('director')->nullable()->after('japanese_name');
            $table->string('poster')->nullable()->after('director');
        });
    }

    public function down(): void
    {
        Schema::table('ghibli_animes', function (Blueprint $table) {
            $table->dropColumn(['synopsis', 'rating', 'japanese_name', 'director', 'poster']);
        });
    }
};
