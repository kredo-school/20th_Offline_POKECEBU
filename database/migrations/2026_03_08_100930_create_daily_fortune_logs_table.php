<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_fortune_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fortune_spot_id')->constrained('fortune_spots')->onDelete('cascade');
            $table->date('fortune_date');
            $table->timestamps();

            $table->unique(['user_id', 'fortune_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_fortune_logs');
    }
};
