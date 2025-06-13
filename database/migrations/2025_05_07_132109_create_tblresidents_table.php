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
        Schema::create('tblresidents', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->string('province');
            $table->string('mun');
            $table->string('barangay');
            $table->string('purok');
            $table->string('philSysNo')->nullable();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('suffix')->nullable();
            $table->date('bdate');
            $table->string('bplace');
            $table->string('sex');
            $table->string('civilstatus');
            $table->string('religion')->nullable();
            $table->string('residenceadd');
            $table->string('citizenship');
            $table->string('highesteducation')->nullable();
            $table->string('name')->nullable();
            $table->binary('signature')->nullable();
            $table->binary('thumbmarkLeft')->nullable();
            $table->binary('thumbmarkRight')->nullable();
            $table->string('attestedby')->nullable();
            $table->string('householdNo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblresidents');
    }
};
