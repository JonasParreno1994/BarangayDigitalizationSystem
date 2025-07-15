<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('death_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained()->onDelete('cascade');
            $table->date('date_of_death');
            $table->time('time_of_death')->nullable();
            $table->string('place_of_death');
            $table->string('cause_of_death');
            $table->string('civil_status_at_death');
            $table->string('purok')->nullable();
            $table->date('date_of_issuance');
            $table->string('status')->default('Issued');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('death_certificates');
    }
};