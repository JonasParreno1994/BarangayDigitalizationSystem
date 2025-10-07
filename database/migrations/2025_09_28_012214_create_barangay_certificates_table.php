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
        Schema::create('barangay_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents')->onDelete('cascade');
            $table->text('purpose');
            $table->integer('residence_period_months')->nullable();
            $table->integer('residence_period_years')->nullable();
            $table->string('cedula_number')->nullable();
            $table->date('date_of_issuance');
            $table->string('or_number')->nullable();
            $table->decimal('amount_paid', 8, 2)->nullable();
            $table->string('status')->default('issued');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_certificates');
    }
};
