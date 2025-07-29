<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboard_items', function (Blueprint $table) {
            $table->id();
            $table->string('image1_path')->nullable();
            $table->string('image2_path')->nullable();
            $table->string('image3_path')->nullable();
            $table->string('image4_path')->nullable();
            $table->string('image5_path')->nullable();
            $table->text('description1');
            $table->text('description2');
            $table->text('description3');
            $table->text('description4');
            $table->text('description5');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dashboard_items');
    }
};