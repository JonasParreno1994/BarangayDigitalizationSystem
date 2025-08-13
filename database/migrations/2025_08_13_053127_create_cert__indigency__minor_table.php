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
        Schema::create('cert__indigency__minor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents');
            $table->string('purpose');
            $table->string('purok');
            $table->string('childsName');
            $table->string('childsAge');
            $table->string('childsGender');
            $table->string('status')->default('Pending');
            $table->date('date_of_issuance');
            $table->string('or_number')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cert__indigency__minor');
    }
};
