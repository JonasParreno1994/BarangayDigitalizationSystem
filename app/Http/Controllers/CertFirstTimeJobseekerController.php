<?php

namespace App\Http\Controllers;

use App\Models\CertFirstTimeJobseeker;
use App\Models\ResidentModel;
use App\Models\BarangayIdDetail;
use App\Models\Official;
use Illuminate\Http\Request;

class CertFirstTimeJobseekerController extends Controller
{
    public function index()
    {
        $certs = CertFirstTimeJobseeker::with('resident')->get();
        return view('cert_firstTime_Jobseeker.index', compact('certs'));
    }
    

}
