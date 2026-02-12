<?php

namespace App\Http\Controllers;

use App\Models\KpCase;
use App\Models\Official;
use App\Traits\HasBarangayDetails;
use Illuminate\Http\Request;

class KpCaseController extends Controller
{
    use HasBarangayDetails;
    public function index()
    {
        $kpCases = KpCase::all();
        return view('kps.index', compact('kpCases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'case_no' => 'required|string|unique:kp_cases,case_no',
            'complainants' => 'required|string',
            'responders' => 'required|string',
            'dispute_type' => 'required|string',
            'nature_of_dispute' => 'nullable|string',
            'mode_of_settlement' => 'nullable|string',
            'action_taken' => 'nullable|string',
        ]);

        KpCase::create($validated);

        return redirect()->route('kp-cases.index')->with('success', 'KP Case added successfully.');
    }

    public function edit($id)
    {
        $kpCase = KpCase::findOrFail($id);
        return view('kps.edit', compact('kpCase'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'case_no' => 'required|string|unique:kp_cases,case_no,' . $id,
            'complainants' => 'required|string',
            'responders' => 'required|string',
            'dispute_type' => 'required|string',
            'nature_of_dispute' => 'nullable|string',
            'mode_of_settlement' => 'nullable|string',
            'action_taken' => 'nullable|string',
        ]);

        $kpCase = KpCase::findOrFail($id);
        $kpCase->update($validated);

        return redirect()->route('kp-cases.index')->with('success', 'KP Case updated successfully.');
    }

    public function destroy($id)
    {
        $kpCase = KpCase::findOrFail($id);
        $kpCase->delete();

        return redirect()->route('kp-cases.index')->with('success', 'KP Case deleted successfully.');
    }

    public function print($id)
    {
        $kpCase = KpCase::findOrFail($id);
        $barangayDetails = $this->getBarangayDetailsForPrint();
        
        $officials = Official::with('position')
            ->active()
            ->get()
            ->sortBy(function($official) {
                if (str_contains($official->position->name, 'Punong Barangay')) {
                    return 0;
                } elseif (str_contains($official->position->name, 'Secretary')) {
                    return 1;
                } elseif (str_contains($official->position->name, 'Treasurer')) {
                    return 2;
                } else {
                    return 3;
                }
            });

        return view('kps.print', compact('kpCase', 'barangayDetails', 'officials'));
    }

    public function showReportForm()
    {
        // Fetch KP Cases grouped by Month and Year for the chart
        $casesByMonth = KpCase::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = [];
        $chartData = [];

        foreach ($casesByMonth as $data) {
            $date = \Carbon\Carbon::createFromDate($data->year, $data->month, 1);
            $chartLabels[] = $date->format('F Y');
            $chartData[] = $data->count;
        }

        // Fetch Nature of Dispute Data
        $natureData = KpCase::select('nature_of_dispute', \DB::raw('count(*) as count'))
            ->groupBy('nature_of_dispute')
            ->get();
        
        $natureLabels = $natureData->pluck('nature_of_dispute');
        $natureCounts = $natureData->pluck('count');

        // Fetch Mode of Settlement Data
        $settlementData = KpCase::select('mode_of_settlement', \DB::raw('count(*) as count'))
            ->whereNotNull('mode_of_settlement')
            ->where('mode_of_settlement', '!=', '')
            ->groupBy('mode_of_settlement')
            ->get();

        $settlementLabels = $settlementData->pluck('mode_of_settlement');
        $settlementCounts = $settlementData->pluck('count');

        return view('kps.report_form', compact('chartLabels', 'chartData', 'natureLabels', 'natureCounts', 'settlementLabels', 'settlementCounts'));
    }

    public function generateReport(Request $request)
    {
        $query = KpCase::query();

        if ($request->filled('nature_of_dispute')) {
            $query->where('nature_of_dispute', $request->nature_of_dispute);
        }

        if ($request->filled('mode_of_settlement')) {
            $query->where('mode_of_settlement', $request->mode_of_settlement);
        }

        if ($request->filled('action_taken')) {
            $query->where('action_taken', $request->action_taken);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $kpCases = $query->get();
        $barangayDetails = $this->getBarangayDetailsForPrint();
        $filters = $request->only(['nature_of_dispute', 'mode_of_settlement', 'action_taken', 'date_from', 'date_to']);

        return view('kps.report', compact('kpCases', 'barangayDetails', 'filters'));
    }

    public function generateComplianceReport(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $kpCases = KpCase::whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->orderBy('case_no', 'asc')
            ->get();

        $barangayDetails = $this->getBarangayDetailsForPrint();
        $captainName = $barangayDetails ? strtoupper($barangayDetails->captain_name) : '________________';
        
        $secretary = Official::with('position')
            ->active()
            ->whereHas('position', function($query) {
                $query->where('name', 'like', '%Secretary%');
            })
            ->first();
        $secretaryName = $secretary ? strtoupper($secretary->name) : '________________';

        // Calculate totals
        $totals = [
            'nature_criminal' => $kpCases->where('nature_of_dispute', 'Criminal')->count(),
            'nature_civil' => $kpCases->where('nature_of_dispute', 'Civil')->count(),
            'nature_others' => $kpCases->where('nature_of_dispute', 'Others')->count(),
            'settled_mediation' => $kpCases->where('mode_of_settlement', 'Mediation')->count(),
            'settled_conciliation' => $kpCases->where('mode_of_settlement', 'Conciliation')->count(),
            'settled_arbitration' => $kpCases->where('mode_of_settlement', 'Arbitration')->count(),
            'action_repudiated' => $kpCases->where('action_taken', 'Repudiated')->count(),
            'action_withdrawn' => $kpCases->where('action_taken', 'Withdrawn')->count(),
            'action_pending' => $kpCases->where('action_taken', 'Pending')->count(),
            'action_dismissed' => $kpCases->where('action_taken', 'Dismissed')->count(),
            'action_certified' => $kpCases->where('action_taken', 'Certified to file action')->count(),
            'action_referred' => $kpCases->where('action_taken', 'Referred to concerned agencies')->count(),
        ];
        
        $totals['nature_total'] = $totals['nature_criminal'] + $totals['nature_civil'] + $totals['nature_others'];

        return view('kps.compliance_report', compact('kpCases', 'barangayDetails', 'dateFrom', 'dateTo', 'totals', 'captainName', 'secretaryName'));
    }
}
