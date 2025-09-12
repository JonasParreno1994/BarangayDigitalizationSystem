<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barangay_details', function (Blueprint $table) {
            $table->id();
            
            // Location Information
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('barangay_name')->nullable();
            $table->string('district')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('complete_address')->nullable();
            
            // Official Information
            $table->string('captain_name')->nullable();
            $table->string('captain_title')->default('Barangay Captain');
            $table->string('secretary_name')->nullable();
            $table->string('secretary_title')->default('Barangay Secretary');
            $table->string('treasurer_name')->nullable();
            $table->string('treasurer_title')->default('Barangay Treasurer');
            
            // Contact Information
            $table->string('barangay_contact')->nullable();
            $table->string('barangay_email')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('office_hours')->default('8:00 AM - 5:00 PM, Monday to Friday');
            
            // Header Information for Documents
            $table->string('heading1')->default('REPUBLIC OF THE PHILIPPINES');
            $table->string('heading2')->nullable();
            $table->string('heading3')->nullable();
            $table->text('document_footer')->nullable();
            
            // Logo and Signature Paths
            $table->string('logo1_path')->nullable();
            $table->string('logo2_path')->nullable();
            $table->string('municipal_logo_path')->nullable();
            $table->string('captain_signature_path')->nullable();
            $table->string('secretary_signature_path')->nullable();
            
            // Certificate Settings
            $table->string('certificate_validity_period')->default('1 year');
            $table->string('or_number_prefix')->default('OR-');
            $table->string('document_series_prefix')->default('2024-');
            
            // Fees (in PHP)
            $table->decimal('clearance_fee', 8, 2)->default(50.00);
            $table->decimal('residency_fee', 8, 2)->default(30.00);
            $table->decimal('indigency_fee', 8, 2)->default(20.00);
            $table->decimal('good_moral_fee', 8, 2)->default(30.00);
            $table->decimal('death_cert_fee', 8, 2)->default(50.00);
            $table->decimal('jobseeker_fee', 8, 2)->default(0.00);
            $table->decimal('id_replacement_fee', 8, 2)->default(100.00);
            
            // Additional Information
            $table->date('barangay_established_date')->nullable();
            $table->string('total_area')->nullable();
            $table->integer('total_population')->nullable();
            $table->integer('total_households')->nullable();
            $table->string('barangay_classification')->nullable(); // Urban/Rural
            $table->string('income_classification')->nullable(); // 1st Class, 2nd Class, etc.
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Indexes
            $table->index('is_active');
            $table->index('barangay_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangay_details');
    }
};
