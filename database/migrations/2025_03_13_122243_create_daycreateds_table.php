<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daycreateds', function (Blueprint $table) {
            $table->id();
            $table->integer('Monday');
            $table->integer('Tuesday');
            $table->integer('Wednesday');
            $table->integer('Thursday');
            $table->integer('Friday');
            $table->integer('Saturday');
            $table->integer('Sunday');
            $table->integer('day_counter')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daycreateds');
    }
};
