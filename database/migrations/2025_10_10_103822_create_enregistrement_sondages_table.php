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
        Schema::create('enregistrement_sondages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sondage_id')->constrained()->onDelete('cascade');
            $table->uuid('groupe_id')->nullable();

            $table->string('label');
            $table->string('value')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            // <-- correction ici
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enregistrement_sondages');
    }
};
