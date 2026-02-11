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
        Schema::create('tmp_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('star_rating', 2, 1)->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            // 2/6 追加：代表者情報
            $table->string('representative_name')->nullable();
            $table->string('representative_email')->nullable()->index();
            $table->string('status')->default('pending');;
            // $table->foreignId('updated_user')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_restaurants');
    }
};
