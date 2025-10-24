<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedule_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id')->constrained('schedule_sets')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedInteger('per_date_quota')->nullable();
            $table->timestamps();
            $table->unique(['set_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_dates');
    }
};
