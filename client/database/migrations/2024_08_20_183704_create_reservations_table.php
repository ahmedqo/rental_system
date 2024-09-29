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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company')->nullable();
            $table->unsignedBigInteger('vehicle')->nullable();
            $table->unsignedBigInteger('agency')->nullable();
            $table->unsignedBigInteger('client')->nullable();
            $table->unsignedBigInteger('secondary_client')->nullable();

            $table->string('reference')->unique();

            $table->dateTime('pickup_date');
            $table->string('pickup_location')->nullable();

            $table->dateTime('dropoff_date');
            $table->string('dropoff_location')->nullable();

            $table->integer('mileage');
            $table->float('fuel_level', 15, 5);
            $table->json('condition');
            $table->integer('rental_period_days');

            $table->string('status');
            $table->timestamps();

            $table->foreign('company')->references('id')->on('companies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('vehicle')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('agency')->references('id')->on('agencies')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('client')->references('id')->on('clients')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('secondary_client')->references('id')->on('clients')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
