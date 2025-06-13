<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComelecModel;
use Illuminate\Support\Facades\DB;

class ComelecController extends Controller
{
    public function comelecData(){
        $comelec = ComelecModel::all();
        return view('comelecFolder.index', compact('comelec'));
    }

    
    public function getNames()
    {
        $names = DB::table('tblcomelec')->select('id', 'name')->get();
        return response()->json($names);
    }

    public function getNameDetails($id)
    {
        $details = DB::table('tblcomelec')->where('id', $id)->first();

        if (!$details) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($details);
    }
}
