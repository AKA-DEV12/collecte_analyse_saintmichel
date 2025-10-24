<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedule_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aumonier_id')->constrained('aumoniers')->cascadeOnDelete();
            $table->boolean('use_global_quota')->default(false);
            $table->unsignedInteger('global_quota')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_sets');
    }
};
