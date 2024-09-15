<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('event-user-manager.tables.event_notes', 'event_notes'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained(config('event-user-manager.tables.events', 'events'))->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('event-user-manager.tables.event_notes', 'event_notes'));
    }
};