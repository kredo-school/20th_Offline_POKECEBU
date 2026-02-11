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
        Schema::create('restaurants', function (Blueprint $table) {
            // $table->id();
            // 2/6 変更後
            $table->unsignedBigInteger('id')->primary();
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');


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
            
            // 2/6 updated_user は削除
            // $table->foreignId('updated_user')->nullable()->constrained('users');
;
            $table->string('image_path')->nullable();        // ← 追加
            $table->string('email', 100)->nullable();       // ← 追加
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
