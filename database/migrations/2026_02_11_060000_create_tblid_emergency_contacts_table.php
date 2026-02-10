<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblid_emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resident_id')->unique();
            $table->string('contact_name');
            $table->string('contact_number');
            $table->string('contact_address');
            $table->timestamps();

            $table->foreign('resident_id')
                  ->references('id')
                  ->on('tblresidents')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblid_emergency_contacts');
    }
};
