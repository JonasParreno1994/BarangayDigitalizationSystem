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
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->string('household_number')->unique();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('barangay')->nullable();
            $table->string('household_address')->nullable();
            $table->integer('number_of_members')->default(0);
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
