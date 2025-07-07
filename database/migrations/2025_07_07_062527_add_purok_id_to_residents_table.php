<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->foreignId('purok_id')->nullable()->constrained('puroks');
        });
    }

    public function down()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropForeign(['purok_id']);
            $table->dropColumn('purok_id');
        });
    }
};