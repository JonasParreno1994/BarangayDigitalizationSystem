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
            $table->boolean('is_indigenous')->default(false)->after('number_of_children');
        });
    }

    public function down()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropColumn('is_indigenous');
        });
    }
};
