<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_appointments', function (Blueprint $table): void {
            $table->id();
            $table->string('user_identifier')->index();
            $table->string('service');
            $table->string('date');
            $table->string('time');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_appointments');
    }
};
