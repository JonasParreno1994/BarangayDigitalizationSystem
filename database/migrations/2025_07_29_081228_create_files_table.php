<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tblfiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('tblresidents')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('tblfilescategory')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size');
            $table->text('description')->nullable();
            $table->date('upload_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tblfiles');
    }
};