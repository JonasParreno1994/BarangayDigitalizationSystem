<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->boolean('is_ofw')->default(false)->after('is_indigenous');
            $table->string('ofw_country')->nullable()->after('is_ofw');
            $table->boolean('is_unemployed')->default(false)->after('ofw_country');
        });
    }

    public function down()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropColumn(['is_ofw', 'ofw_country', 'is_unemployed']);
        });
    }
};
