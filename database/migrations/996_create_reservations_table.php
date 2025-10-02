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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('channel')->nullable();
            $table->date('arrival_date')->nullable();
            $table->date('date_in')->nullable();
            $table->date('date_out')->nullable();
            $table->integer('guests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled','No Show'])->default('pending');

            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->foreign("room_id")->references("id")->on("rooms")->onDelete("cascade");
            $table->foreign("trip_id")->references("id")->on("trips")->onDelete("cascade");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
