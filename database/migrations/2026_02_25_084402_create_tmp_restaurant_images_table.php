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
        Schema::create('tmp_restaurant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tmp_restaurant_id')->constrained('tmp_restaurants')->cascadeOnDelete();
            $table->string('image'); // storage パスを保存
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_restaurant_images');
    }
};
