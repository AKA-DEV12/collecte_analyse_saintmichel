<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aumonier_id')->constrained('aumoniers')->cascadeOnDelete();
            $table->foreignId('date_id')->constrained('schedule_dates')->cascadeOnDelete();
            $table->foreignId('slot_id')->constrained('schedule_slots')->cascadeOnDelete();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('subject');
            $table->enum('status', ['pending', 'done', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
