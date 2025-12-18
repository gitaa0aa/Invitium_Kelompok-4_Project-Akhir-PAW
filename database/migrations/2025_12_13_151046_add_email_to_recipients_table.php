<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recipients', function (Blueprint $table) {
            if (!Schema::hasColumn('recipients', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('recipients', function (Blueprint $table) {
            if (Schema::hasColumn('recipients', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
