<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangayClearance;
use App\Models\CertificateOfIndigency;
use App\Models\BarangayGoodMoralCertificate;
use App\Models\CertificateOfResidency;
use App\Models\BarangayIdDetail;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'certificate_type' => 'required|in:all,clearance,indigency,moral,residency',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'status' => 'nullable|in:all,issued,pending,rejected',
        ]);

        $certificateType = $request->certificate_type;
        $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : null;
        $dateTo = $request->date_to ? Carbon::parse($request->date_to) : null;
        $status = $request->status;

        $results = [];

        if ($certificateType === 'all' || $certificateType === 'clearance') {
            $clearances = BarangayClearance::query();
            if ($dateFrom) $clearances->where('created_at', '>=', $dateFrom);
            if ($dateTo) $clearances->where('created_at', '<=', $dateTo->endOfDay());
            if ($status && $status !== 'all') $clearances->where('status', $status);
            $results['clearances'] = $clearances->get();
        }

        if ($certificateType === 'all' || $certificateType === 'indigency') {
            $indigencies = CertificateOfIndigency::query();
            if ($dateFrom) $indigencies->where('created_at', '>=', $dateFrom);
            if ($dateTo) $indigencies->where('created_at', '<=', $dateTo->endOfDay());
            if ($status && $status !== 'all') $indigencies->where('status', $status);
            $results['indigencies'] = $indigencies->get();
        }

        if ($certificateType === 'all' || $certificateType === 'moral') {
            $morals = BarangayGoodMoralCertificate::query();
            if ($dateFrom) $morals->where('created_at', '>=', $dateFrom);
            if ($dateTo) $morals->where('created_at', '<=', $dateTo->endOfDay());
            if ($status && $status !== 'all') $morals->where('status', $status);
            $results['morals'] = $morals->get();
        }

        if ($certificateType === 'all' || $certificateType === 'residency') {
            $residencies = CertificateOfResidency::query();
            if ($dateFrom) $residencies->where('created_at', '>=', $dateFrom);
            if ($dateTo) $residencies->where('created_at', '<=', $dateTo->endOfDay());
            if ($status && $status !== 'all') $residencies->where('status', $status);
            $results['residencies'] = $residencies->get();
        }

        return view('reports.results', [
            'results' => $results,
            'filters' => $request->all(),
            'totalCount' => $this->calculateTotalCount($results)
        ]);
    }

    public function print(Request $request)
    {
        $results = $this->generate($request)->getData();
        $barangayDetails = BarangayIdDetail::latest()->first();
    
        return view('reports.print', array_merge((array)$results, [
            'barangayDetails' => $barangayDetails
        ]));
    }

    private function calculateTotalCount($results)
    {
        $count = 0;
        foreach ($results as $type => $collection) {
            $count += $collection->count();
        }
        return $count;
    }
}