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
            $table->foreignId('timeslot_id')->constrained('timeslots')->onDelete('cascade');
            $table->text('total')->nullable();
            $table->enum('state', ['paid', 'locked', 'unlocked'])->default('locked');
            $table->timestamps();
            $table->foreignId('user_id')->default(1)->constrained()->onDelete('cascade');
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
