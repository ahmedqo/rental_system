<?php

use App\Functions\Core;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company')->nullable();
            $table->enum('registration_type', Core::registrationList());
            $table->string('registration_number');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->decimal('daily_rate', 15, 5);

            $table->integer('passenger_capacity');
            $table->integer('mileage');
            $table->integer('number_of_doors');
            $table->integer('cargo_capacity');
            $table->enum('transmission_type', Core::transmissionsList());
            $table->enum('fuel_type', Core::fuelsList());

            $table->date('registration_date');
            $table->enum('horsepower', Core::horsepowersList());
            $table->decimal('horsepower_tax', 15, 5);
            $table->string('insurance_company');
            $table->date('insurance_issued_at');
            $table->decimal('insurance_cost', 15, 5);

            $table->decimal('loan_amount', 15, 5)->nullable();
            $table->decimal('monthly_installment', 15, 5)->nullable();
            $table->date('loan_issued_at')->nullable();

            $table->integer('paid_period')->nullable();
            $table->integer('due_period')->nullable();
            $table->decimal('paid_amount', 15, 5)->nullable();
            $table->decimal('due_amount', 15, 5)->nullable();
            $table->timestamps();

            $table->foreign('company')->references('id')->on('companies')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
