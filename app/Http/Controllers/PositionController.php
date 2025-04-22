<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function positionData()
    {
        $position = Position::all();
        return view('positionFolder.index', compact('position'));
    }
}
