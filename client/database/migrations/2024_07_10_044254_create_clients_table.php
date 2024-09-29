<?php

use App\Functions\Core;
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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company')->nullable();

            $table->enum('identity_type', Core::identitiesList());
            $table->string('identity_number')->unique();
            $table->string('identity_issued_in');
            $table->date('identity_issued_at');

            $table->string('license_number')->unique();
            $table->string('license_issued_in');
            $table->date('license_issued_at');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->enum('nationality', Core::nationsList());

            $table->enum('gender', Core::genderList());
            $table->date('birth_date');
            $table->enum('city', Core::citiesList());
            $table->string('zipcode');
            $table->string('address');

            $table->timestamps();

            $table->foreign('company')->references('id')->on('companies')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
