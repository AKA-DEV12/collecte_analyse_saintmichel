<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tel')) {
                $table->string('tel')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'fonction')) {
                $table->string('fonction')->nullable()->after('tel');
            }
            if (!Schema::hasColumn('users', 'ceb')) {
                $table->string('ceb')->nullable()->after('fonction');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->tinyInteger('role')->default(0)->after('ceb');
            }
            if (!Schema::hasColumn('users', 'type_agent')) {
                $table->tinyInteger('type_agent')->nullable()->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'type_agent')) {
                $table->dropColumn('type_agent');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'ceb')) {
                $table->dropColumn('ceb');
            }
            if (Schema::hasColumn('users', 'fonction')) {
                $table->dropColumn('fonction');
            }
            if (Schema::hasColumn('users', 'tel')) {
                $table->dropColumn('tel');
            }
        });
    }
};
