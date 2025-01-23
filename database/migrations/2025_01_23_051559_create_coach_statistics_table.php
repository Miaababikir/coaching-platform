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
        Schema::create('coach_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('coaches');
            $table->unsignedBigInteger('total_clients')->default(0);
            $table->unsignedBigInteger('total_sessions')->default(0);
            $table->unsignedBigInteger('completed_sessions')->default(0);
            $table->unsignedBigInteger('scheduled_sessions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coach_statistics');
    }
};
