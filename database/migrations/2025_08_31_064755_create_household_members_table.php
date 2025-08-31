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
        Schema::create('household_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->constrained()->onDelete('cascade');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('age')->nullable();
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Divorced', 'Separated']);
            $table->string('citizenship')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('labor_employment_status', [
                'Labor/employed',
                'Unemployed', 
                'PWD',
                'Solo Parent',
                'Out of School Youth (OSY)',
                'Out of School Children (OSC)',
                'IP'
            ])->nullable();
            $table->string('relationship_to_head')->nullable();
            $table->boolean('is_head')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('household_members');
    }
};
