<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();

            $table->string('letter_number')->unique();
            $table->date('letter_date');

            $table->string('hal')->nullable();
            $table->string('lampiran_text')->nullable();

            $table->string('kop_path')->nullable();

            $table->text('description');

            $table->date('event_date');
            $table->string('event_time');
            $table->string('event_place');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
