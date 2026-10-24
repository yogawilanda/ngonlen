<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->json('model');
            $table->timestamps();

            $table->unique(['team_id', 'slug']);
            $table->index(['team_id', 'updated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
