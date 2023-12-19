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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('rcrmVisitorId')->nullable();
            $table->string('sessionId')->nullable();
            $table->text('referrer')->nullable();
            $table->text('initial_url')->nullable();
            $table->text('url_visited')->nullable();
            $table->string('dateTime');
            $table->string('country')->nullable();
            $table->text('userAgent')->nullable();
            $table->binary('deviceInfo')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
