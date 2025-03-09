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
        Schema::create(table: 'settings', callback: function(Blueprint $table) {
            $table->increments('id');
            $table->string(column: 'logo')->nullable();
            $table->string(column: 'favicon')->nullable();
            $table->string(column: 'facebook')->nullable();
            $table->string(column: 'instagram')->nullable();
            $table->string(column: 'phone')->nullable();
            $table->string(column: 'email')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'settings');
    }
};
