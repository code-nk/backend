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
        Schema::create('calendly_records', function (Blueprint $table) {
                $table->id();
                $table->string('cancel_url')->nullable();
                $table->string('email')->nullable();
                $table->string('name')->nullable();;
                $table->string('reschedule_url')->nullable();
                $table->boolean('rescheduled')->nullable();
                $table->string('status')->nullable();
                $table->string('text_reminder_number')->nullable();
                $table->string('timezone')->nullable();
                $table->string('start_time')->nullable();
                $table->string('membership_user')->nullable();
                $table->string('membership_email')->nullable();
                $table->string('guest_email')->nullable();
                $table->string('end_time')->nullable();
                $table->string('uri')->nullable();
                $table->string('utm_campaign')->nullable();
                $table->string('utm_source')->nullable();
                $table->string('utm_medium')->nullable();
                $table->string('utm_content')->nullable();
                $table->string('utm_term')->nullable();
                $table->unsignedBigInteger('event_id');
                $table->timestamps();

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendly_records');
    }
};
