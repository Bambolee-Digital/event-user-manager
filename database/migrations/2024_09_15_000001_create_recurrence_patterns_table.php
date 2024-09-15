<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(config('event-user-manager.tables.recurrence_patterns', 'recurrence_patterns'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('frequency_type');
            $table->integer('interval');
            $table->json('days')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('event-user-manager.tables.recurrence_patterns', 'recurrence_patterns'));
    }
};