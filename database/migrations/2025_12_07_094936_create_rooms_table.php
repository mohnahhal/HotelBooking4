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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('room_number')->nullable();
            $table->string('name'); // جناح فاخر، غرفة مزدوجة...
            $table->string('slug');
            $table->text('description');
            $table->integer('max_guests')->default(2);
            $table->integer('size')->nullable(); // بالمتر المربع
            $table->json('amenities')->nullable(); // مزايا الغرفة
            $table->json('images')->nullable();
            $table->integer('quantity')->default(1); // عدد الغرف من هذا النوع
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
