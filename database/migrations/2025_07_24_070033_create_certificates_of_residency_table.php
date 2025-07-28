<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates_of_residency', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents');
            $table->string('purpose');
            $table->string('cedula_number')->nullable();
            $table->date('date_of_issuance');
            $table->string('or_number')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('status')->default('Issued');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates_of_residency');
    }
};