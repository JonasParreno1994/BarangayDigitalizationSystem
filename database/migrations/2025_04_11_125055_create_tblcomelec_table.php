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
        Schema::create('tblcomelec', function (Blueprint $table) {
            $table->id();
            $table->string('precinct_no');
            $table->string('no');
            $table->string('name');
            $table->string('barangay');
            $table->string('purok');
            $table->string('random'); // Add your new column here
            $table->string('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblcomelec');
    }
};
