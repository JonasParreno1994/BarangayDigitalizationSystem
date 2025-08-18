<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificate_of_death', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents')->onDelete('cascade');
            $table->date('date_of_death');
            $table->string('place_of_death');
            $table->string('cause_of_death');
            $table->date('date_of_issuance');
            $table->string('certificate_number')->unique();
            $table->text('remarks')->nullable();
            $table->string('status')->default('Issued');
            $table->string('issued_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificate_of_death');
    }
};