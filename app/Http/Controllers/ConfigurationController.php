<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    // there is only one record in the config file
    public function show()
    {
        $config = Configuration::find(1);

        return response()->json($config);
    }
}
