<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitation_signatures', function (Blueprint $table) {
            if (!Schema::hasColumn('invitation_signatures', 'signer_position')) {
                $table->string('signer_position')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('invitation_signatures', 'signer_name')) {
                $table->string('signer_name')->nullable()->after('signer_position');
            }
            if (!Schema::hasColumn('invitation_signatures', 'signer_identity')) {
                $table->string('signer_identity')->nullable()->after('signer_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invitation_signatures', function (Blueprint $table) {
            if (Schema::hasColumn('invitation_signatures', 'signer_identity')) {
                $table->dropColumn('signer_identity');
            }
            if (Schema::hasColumn('invitation_signatures', 'signer_name')) {
                $table->dropColumn('signer_name');
            }
            if (Schema::hasColumn('invitation_signatures', 'signer_position')) {
                $table->dropColumn('signer_position');
            }
        });
    }
};
