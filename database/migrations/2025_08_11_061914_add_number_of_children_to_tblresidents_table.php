<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->integer('number_of_children')->nullable()->default(0)->after('solo_parent_id');
        });
    }

    public function down()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropColumn('number_of_children');
        });
    }
};
