<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('event-user-manager.tables.events', 'events'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(config('event-user-manager.user_table', 'users'))->onDelete('cascade');
            $table->foreignId('event_type_id')->constrained(config('event-user-manager.tables.event_types', 'event_types'))->onDelete('cascade');
            $table->foreignId('recurrence_pattern_id')->nullable()->constrained(config('event-user-manager.tables.recurrence_patterns', 'recurrence_patterns'))->onDelete('set null');
            $table->string('name');
            $table->text('description');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->integer('duration_hours')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->enum('status', ['draft', 'active', 'past', 'cancelled', 'pending', 'rescheduled'])->default('draft');
            $table->integer('frequency_count')->nullable();
            $table->string('frequency_type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('event-user-manager.tables.events', 'events'));
    }
};