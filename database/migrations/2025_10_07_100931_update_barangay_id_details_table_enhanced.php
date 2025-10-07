<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barangay_id_details', function (Blueprint $table) {
            // Enhanced header information
            $table->string('office_info')->nullable()->after('heading3'); // "Office of the Punong Barangay"
            $table->string('ordinance_info')->nullable()->after('office_info'); // "Brgy. Ord. 001 S. of 2021 | SB Res. 2021-202"
            
            // Card footer information
            $table->text('footer_text')->nullable()->after('details'); // "ISSUED BASED UPON INFORMATION FURNISHED BY APPLICANT."
            $table->string('card_title')->nullable()->after('footer_text'); // "BARANGAY IDENTIFICATION CARD"
            
            // Back side information
            $table->string('back_header')->nullable()->after('card_title'); // "THIS CARD IS NON-TRANSFERABLE"
            $table->text('back_certification')->nullable()->after('back_header'); // Certification text
            $table->text('back_note')->nullable()->after('back_certification'); // Note about validity and signing
            $table->text('back_loss_info')->nullable()->after('back_note'); // Loss reporting information
            $table->string('emergency_contact_name')->nullable()->after('back_loss_info'); // Emergency contact name
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_name'); // Emergency contact number
            $table->string('emergency_contact_address')->nullable()->after('emergency_contact_number'); // Emergency contact address
            
            // Additional styling and layout options
            $table->string('card_color_scheme')->default('blue')->after('emergency_contact_address'); // Color scheme
            $table->boolean('include_fingerprint')->default(true)->after('card_color_scheme'); // Include fingerprint section
            $table->boolean('include_qr_code')->default(true)->after('include_fingerprint'); // Include QR code
            $table->integer('validity_years')->default(3)->after('include_qr_code'); // Validity in years
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangay_id_details', function (Blueprint $table) {
            $table->dropColumn([
                'office_info',
                'ordinance_info', 
                'footer_text',
                'card_title',
                'back_header',
                'back_certification',
                'back_note',
                'back_loss_info',
                'emergency_contact_name',
                'emergency_contact_number',
                'emergency_contact_address',
                'card_color_scheme',
                'include_fingerprint',
                'include_qr_code',
                'validity_years'
            ]);
        });
    }
};
