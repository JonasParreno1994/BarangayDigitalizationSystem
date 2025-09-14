# Barangay Details System - Implementation Guide

## Overview

The Barangay Details System provides a centralized way to manage and fetch barangay information across all forms and documents in the Barangay Digitalization System. This ensures consistency and makes it easy to update information without modifying multiple files.

## Features

### 1. Comprehensive Information Storage
- **Location Information**: Region, province, city/municipality, barangay name, district, ZIP code
- **Official Information**: Captain, secretary, treasurer names and titles
- **Contact Information**: Phone, email, emergency contacts, office hours
- **Document Settings**: Headers, footers, validity periods, OR number prefixes
- **Fees Management**: Individual fees for different document types
- **Logos & Signatures**: Support for multiple logos and official signatures
- **Additional Information**: Population, area, establishment date, classification

### 2. Backward Compatibility
- Falls back to existing `BarangayIdDetail` model if new system is not set up
- Provides default values if no data is found
- Seamless integration with existing forms

## Implementation

### 1. Model Structure

**BarangayDetail Model** (`app/Models/BarangayDetail.php`)
- Comprehensive model with all barangay information
- Helper methods for formatted headers and fee calculations
- Active/inactive status management

### 2. Service Layer

**BarangayDetailsService** (`app/Services/BarangayDetailsService.php`)
- Static methods for easy access from anywhere in the application
- Automatic fallback to legacy system
- Helper methods for common operations

### 3. Trait for Controllers

**HasBarangayDetails Trait** (`app/Traits/HasBarangayDetails.php`)
- Easy integration into existing controllers
- Consistent method names across controllers
- Automatic fallback handling

## Usage Examples

### 1. In Controllers

#### Option A: Using the Trait (Recommended for new implementations)
```php
use App\Traits\HasBarangayDetails;

class YourController extends Controller
{
    use HasBarangayDetails;

    public function yourMethod()
    {
        $barangayDetails = $this->getBarangayDetailsForPrint();
        return view('your.view', compact('barangayDetails'));
    }
}
```

#### Option B: Using the Service (Quick implementation)
```php
use App\Services\BarangayDetailsService;

class YourController extends Controller
{
    public function yourMethod()
    {
        $barangayDetails = BarangayDetailsService::getDetails();
        return view('your.view', compact('barangayDetails'));
    }
}
```

### 2. In Views

```blade
<!-- Display basic information -->
<h1>{{ $barangayDetails->heading1 ?? 'REPUBLIC OF THE PHILIPPINES' }}</h1>
<h2>{{ $barangayDetails->heading2 ?? $barangayDetails->province . ', ' . $barangayDetails->city_municipality }}</h2>
<h3>{{ $barangayDetails->heading3 ?? 'BARANGAY ' . $barangayDetails->barangay_name }}</h3>

<!-- Display logos -->
@if($barangayDetails && $barangayDetails->logo1_path)
    <img src="{{ asset('storage/' . $barangayDetails->logo1_path) }}" alt="Barangay Logo">
@endif

<!-- Display official information -->
<p>Barangay Captain: {{ $barangayDetails->captain_name ?? 'Not Set' }}</p>
<p>Barangay Secretary: {{ $barangayDetails->secretary_name ?? 'Not Set' }}</p>

<!-- Display contact information -->
<p>Contact: {{ $barangayDetails->barangay_contact ?? 'Not Set' }}</p>
<p>Emergency: {{ $barangayDetails->emergency_contact ?? '911' }}</p>

<!-- Display fees -->
<p>Clearance Fee: ₱{{ number_format($barangayDetails->clearance_fee ?? 50, 2) }}</p>
```

### 3. Getting Specific Information

```php
// Get fee for specific document type
$clearanceFee = BarangayDetailsService::getFee('clearance');

// Get formatted header
$header = BarangayDetailsService::getFormattedHeader();
```

## Management Interface

### Access the Management Interface
1. Navigate to `/barangay-details` in your application
2. Click "Add Barangay Details" if none exist
3. Fill in the comprehensive form with all barangay information
4. Upload logos and signatures as needed

### Features of the Management Interface
- **View Current Details**: See all stored information in an organized layout
- **Edit Details**: Update any information easily
- **Logo Management**: Upload and preview logos
- **Fee Management**: Set fees for different document types
- **Status Management**: Activate/deactivate barangay details

## Migration Guide

### For New Installations
1. Run the migration: `php artisan migrate`
2. Run the seeder: `php artisan db:seed --class=BarangayDetailSeeder`
3. Access `/barangay-details` to customize the information

### For Existing Installations
1. The system automatically falls back to your existing `BarangayIdDetail` data
2. Run the migration to create the new table
3. Optionally run the seeder for sample data
4. Gradually update controllers to use the new system
5. Set up the new comprehensive details through the management interface

## Updated Controllers

The following controllers have been updated to use the new system:
- `RbiFormCController` - Uses trait for better integration
- `CertificateOfIndigencyController` - Updated to use trait

### To Update Other Controllers

Add the trait and replace the barangay details fetching:

```php
// Old way
$barangayDetails = BarangayIdDetail::first();

// New way (using trait)
use App\Traits\HasBarangayDetails;
// Then in the class:
use HasBarangayDetails;
// Then in methods:
$barangayDetails = $this->getBarrangayDetailsForPrint();

// OR using service directly
$barangayDetails = BarangayDetailsService::getDetails();
```

## Database Structure

### Main Table: `barangay_details`
- Comprehensive storage of all barangay information
- File paths for logos and signatures
- Fee structure for different document types
- Status management with `is_active` field

### Fallback: `barangay_id_details`
- Existing table continues to work
- Automatic fallback when new system is not configured

## File Storage

All uploaded files (logos, signatures) are stored in:
- Storage location: `storage/app/public/barangay-files/`
- Public access: `public/storage/barangay-files/`

## Security Considerations

1. **File Upload Validation**: Only image files are allowed for logos/signatures
2. **Authentication**: All management routes require authentication
3. **Input Validation**: All form inputs are properly validated
4. **File Size Limits**: Maximum 2MB per uploaded file

## Troubleshooting

### Common Issues

1. **"Barangay details not found" error**
   - Solution: Create barangay details through the management interface

2. **Images not displaying**
   - Solution: Run `php artisan storage:link` to create storage symlink

3. **Migration issues**
   - Solution: Check database permissions and table conflicts

### Default Fallbacks

If no barangay details are set up, the system provides these defaults:
- Region: VI
- Province: NEGROS OCCIDENTAL
- City/Municipality: HINOBA-AN
- Barangay: BACUYANGAN
- Standard fees for all document types

## Future Enhancements

1. **Multi-language Support**: Add support for local language headers
2. **Template System**: Create different document templates
3. **API Integration**: Provide REST API for external applications
4. **Backup System**: Automatic backup of barangay details
5. **Audit Trail**: Track changes to barangay information

## Support

For technical support or questions about implementing the Barangay Details System:
1. Check the existing controllers for implementation examples
2. Review the trait and service files for available methods
3. Test with the provided seeder data first
4. Ensure proper migration execution and storage linking
