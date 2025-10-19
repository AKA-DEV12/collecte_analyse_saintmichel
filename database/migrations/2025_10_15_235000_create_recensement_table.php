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
        Schema::create('recensements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->date('date_naissance')->nullable();
            $table->string('quartier')->nullable();
            $table->boolean('baptise')->default(false);
            $table->boolean('confirme')->default(false);
            $table->boolean('profession_de_foi')->default(false);
            $table->integer('situation_matrimoniale');
            $table->string('telephone')->nullable();
            $table->string('numero_whatsapp')->nullable();
            $table->string('situation_professionnelle')->nullable();
            $table->string('ceb')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recensement');
    }
};
