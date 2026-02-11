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
        Schema::table('kp_cases', function (Blueprint $table) {
            $table->string('nature_of_dispute')->nullable()->change();
            $table->string('mode_of_settlement')->nullable()->change();
            $table->string('action_taken')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kp_cases', function (Blueprint $table) {
            $table->string('nature_of_dispute')->nullable(false)->change();
            $table->string('mode_of_settlement')->nullable(false)->change();
            $table->string('action_taken')->nullable(false)->change();
        });
    }
};
