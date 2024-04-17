<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licensure;

class LicensureController extends Controller {
    public function index(Request $request) {
        $licensures = Licensure::orderBy('state_name')->orderBy('school_college');

        if ($request->has('state')) {
            $licensures->where('state_name', $request->state);
        }
        
        $licensures = $licensures->paginate(50);

        $states = Licensure::select('state_name')
            ->groupBy('state_name')
            ->orderBy('state_name')
            ->get();

        return view('licensures.index', compact('licensures', 'states'))
            ->fragmentIf($request->hasHeader('HX-Request'), 'licensures');
    }
}