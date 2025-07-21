<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificate_of_indigency', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents');
            $table->string('purpose');
            $table->string('status')->default('Pending');
            $table->date('date_of_issuance');
            $table->string('or_number')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificate_of_indigency');
    }
};