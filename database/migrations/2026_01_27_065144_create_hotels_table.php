<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            // $table->id();
            // id を unsignedBigInteger の主キーにする（auto-increment ではない）
            $table->unsignedBigInteger('id')->primary();
            // users.id と同一にするなら外部キーを追加（推奨）
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

            // 2/6 追加：代表者情報（承認時にユーザー作成・通知で使用）
            $table->string('representative_name')->nullable();
            $table->string('representative_email')->nullable()->index();

            // $table->foreignId('updated_user')->nullable()->constrained('users');
            // 2/6削除
            // $table->foreignId('updated_user')->nullable()->constrained('users')->nullOnDelete();
            // - updated_user は外部キー制約を付けていますが、onDelete('set null') を追加すると、ユーザー削除時にホテルレコードが壊れず残せます。
             $table->string('email')->nullable(); //追か
            $table->string('image_path')->nullable(); // ← 追加
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};

