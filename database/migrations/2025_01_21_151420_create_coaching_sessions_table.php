<?php

use App\Enums\CoachingSessionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coaching_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->string('status')->default(CoachingSessionStatus::Scheduled->value)->index();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('coach_id')->constrained('coaches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaching_sessions');
    }// statistic
};
