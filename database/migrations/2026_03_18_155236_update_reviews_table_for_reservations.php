<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {

            $table->foreignId('hotel_reservation_id')
                ->nullable()
                ->after('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('restaurant_reservation_id')
                ->nullable()
                ->after('hotel_reservation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->dropColumn(['target_type', 'target_id']);

            $table->unique(['user_id', 'hotel_reservation_id']);
            $table->unique(['user_id', 'restaurant_reservation_id']);
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {

            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();

            $table->dropUnique(['user_id', 'hotel_reservation_id']);
            $table->dropUnique(['user_id', 'restaurant_reservation_id']);

            $table->dropColumn([
                'hotel_reservation_id',
                'restaurant_reservation_id'
            ]);
        });
    }
};