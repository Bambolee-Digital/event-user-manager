<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('event-user-manager.tables.event_types', 'event_types'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->boolean('is_custom')->default(false);
            $table->foreignId('user_id')->nullable()->constrained(config('event-user-manager.user_table', 'users'))->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('event-user-manager.tables.event_types', 'event_types'));
    }
};