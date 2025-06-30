<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barangay_id_details', function (Blueprint $table) {
            $table->id();
            $table->string('logo1_path');
            $table->string('logo2_path');
            $table->string('heading1');
            $table->string('heading2');
            $table->string('heading3');
            $table->string('validity');
            $table->text('details');
            $table->string('pass_captain');
            $table->string('signature_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangay_id_details');
    }
};