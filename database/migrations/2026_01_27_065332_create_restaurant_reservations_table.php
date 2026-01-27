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
        Schema::create('restaurant_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('restaurant_id')->constrained();
            $table->foreignId('table_id')->constrained('restaurant_tables');
            $table->foreignId('status_id')->constrained('statuses');
            $table->timestamp('reserved_at');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->integer('guests');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('updated_user')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_reservations');
    }
};
