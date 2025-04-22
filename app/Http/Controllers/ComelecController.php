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

    
}
