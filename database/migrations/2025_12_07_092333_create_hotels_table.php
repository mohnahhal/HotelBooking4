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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المالك
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('address'); 
            $table->string('city');
            $table->string('country');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('phone');
            $table->string('email');
            $table->integer('star_rating')->default(3);
            $table->json('amenities')->nullable(); // وسائل الراحة
            $table->json('images')->nullable(); // صور الفندق
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->date('check_in_date')->default('2011-12-21');
            $table->date('check_out_date')->default('2011-12-22');
            $table->text('policies')->nullable(); // سياسات الفندق
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
