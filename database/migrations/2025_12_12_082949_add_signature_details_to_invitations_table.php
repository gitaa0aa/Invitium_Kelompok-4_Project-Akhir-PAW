<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('invitations')) {
            return;
        }

        Schema::table('invitations', function (Blueprint $table) {
            if (!Schema::hasColumn('invitations', 'signature_details')) {
                $table->text('signature_details')->nullable()->after('kop_path');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('invitations')) {
            return;
        }

        Schema::table('invitations', function (Blueprint $table) {
            if (Schema::hasColumn('invitations', 'signature_details')) {
                $table->dropColumn('signature_details');
            }
        });
    }
};
