<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->enum('status', ['Active', 'Transferred Residence', 'Deceased'])->default('Active');
        });
    }

    public function down()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};