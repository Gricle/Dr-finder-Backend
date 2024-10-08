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
        Schema::create('flies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('airport_id')->constrained()->cascadeOnDelete();
            $table->string('origin');
            $table->string('destination');
            $table->string('description');
            $table->dateTime('takeoff_time');
            $table->dateTime('land_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flies');
    }
};