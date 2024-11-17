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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company')->nullable();

            $table->string('target_id');
            $table->string('target_type');
            $table->string('text')->nullable();
            $table->string('vars')->nullable();
            $table->string('view')->nullable();
            $table->timestamps();

            $table->foreign('company')->references('id')->on('companies')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
