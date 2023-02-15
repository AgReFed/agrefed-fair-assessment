<?php

namespace App\Http\Controllers;

use App\Models\Standard;

class StandardController extends Controller
{
    public function show($id)
    {
        $standard = Standard::find($id);
        return response()->json($standard);

    }

    public function index()
    {

        $standards = Standard::get()->toArray();

        return response($standards);
    }

}
