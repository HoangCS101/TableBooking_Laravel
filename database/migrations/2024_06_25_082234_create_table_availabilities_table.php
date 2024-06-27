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
        Schema::create('table_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->string('guest_name');
            $table->string('pnum');
            $table->date('date');
            $table->enum('time_slot', [
                '07:30 AM - 09:00 AM',
                '09:00 AM - 10:30 AM',
                '10:30 AM - 12:00 PM',
                '12:00 PM - 01:30 PM',
                '01:30 PM - 03:00 PM',
                '03:00 PM - 04:30 PM',
                '04:30 PM - 06:00 PM',
                '06:00 PM - 07:30 PM',
                '07:30 PM - 09:00 PM',
                '09:00 PM - 10:30 PM',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_availabilities');
    }
};
