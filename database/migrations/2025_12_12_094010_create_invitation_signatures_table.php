<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invitation_signatures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invitation_id')
                ->constrained('invitations')
                ->cascadeOnDelete();

            // file ttd WAJIB kalau signer diisi -> enforced di controller
            $table->string('file_path');

            $table->string('signer_position')->nullable();
            $table->string('signer_name')->nullable();
            $table->string('signer_identity')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_signatures');
    }
};
