<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->boolean('is_senior_citizen')->default(false)->after('census_no');
            $table->string('senior_citizen_id')->nullable()->after('is_senior_citizen');
            $table->boolean('is_pwd')->default(false)->after('senior_citizen_id');
            $table->string('pwd_id')->nullable()->after('is_pwd');
            $table->string('pwd_type')->nullable()->after('pwd_id');
            $table->boolean('is_solo_parent')->default(false)->after('pwd_type');
            $table->string('solo_parent_id')->nullable()->after('is_solo_parent');
        });
    }

    public function down()
    {
        Schema::table('tblresidents', function (Blueprint $table) {
            $table->dropColumn([
                'is_senior_citizen',
                'senior_citizen_id',
                'is_pwd',
                'pwd_id',
                'pwd_type',
                'is_solo_parent',
                'solo_parent_id'
            ]);
        });
    }
};