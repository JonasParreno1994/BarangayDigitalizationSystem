<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tblresidents', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated']);
            $table->string('religion')->nullable();
            $table->string('citizenship');
            $table->text('address');
            $table->string('occupation')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->enum('voter_status', ['Voter', 'Non-Voter']);
            $table->string('precinct_number')->nullable();
            $table->string('education')->nullable();
            $table->string('education_status')->nullable();
            $table->string('household_number');
            $table->string('region');
            $table->string('province');
            $table->string('city_municipality');
            $table->string('barangay');
            $table->string('census_no')->nullable();
            $table->boolean('is_senior_citizen')->default(false);
            $table->string('senior_citizen_id')->nullable();
            $table->boolean('is_pwd')->default(false);
            $table->string('pwd_id')->nullable();
            $table->string('pwd_type')->nullable();
            $table->boolean('is_solo_parent')->default(false);
            $table->string('solo_parent_id')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblresidents');
    }
};