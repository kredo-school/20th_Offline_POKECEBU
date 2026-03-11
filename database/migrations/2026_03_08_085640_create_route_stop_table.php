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
    Schema::create('route_stop', function (Blueprint $table) {
        $table->id();

        $table->foreignId('route_id')
            ->constrained('jeepney_routes_table')
            ->cascadeOnDelete();

        $table->foreignId('stop_id')
            ->constrained('jeepney_stops_table')
            ->cascadeOnDelete();

        $table->integer('stop_order');

        $table->timestamps();
    });
}
};
