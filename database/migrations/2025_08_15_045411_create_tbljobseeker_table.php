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
        Schema::create('tbljobseeker', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents');
            $table->string('age');
            $table->string('purok');
            $table->string('barangay');
            $table->string('cedula_number')->nullable();
            $table->date('date_of_issuance');
            $table->string('or_number')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('status')->default('Issued');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbljobseeker');
    }
};
