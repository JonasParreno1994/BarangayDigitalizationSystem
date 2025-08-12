<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certification_footers', function (Blueprint $table) {
            $table->id();
            $table->string('picture1')->nullable();
            $table->string('logo1')->nullable();
            $table->text('logo1description')->nullable();
            $table->string('logo2')->nullable();
            $table->text('logo2description')->nullable();
            $table->string('logo3')->nullable();
            $table->text('logo3description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certification_footers');
    }
};