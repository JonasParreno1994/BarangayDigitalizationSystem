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
        Schema::create('kp_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_no')->unique();
            $table->text('complainants');
            $table->text('responders');
            $table->string('dispute_type');
            $table->string('nature_of_dispute'); // Criminal, Civil, Others
            $table->string('mode_of_settlement'); // Mediation, Conciliation, Arbitration
            $table->string('action_taken'); // Repudiated, Withdrawn, Pending, Dismissed, Certified to file action, Referred to concerned agencies
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kp_cases');
    }
};
