<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->string('emergency_contact_name')->nullable()->after('status');
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_address')->nullable()->after('emergency_contact_number');
        });
    }

    public function down(): void
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropColumn([
                'emergency_contact_name',
                'emergency_contact_number',
                'emergency_contact_address',
            ]);
        });
    }
};
