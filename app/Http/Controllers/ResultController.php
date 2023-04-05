<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{

    public function __construct()
    {
        // all routes limited to logged in users
        $this->middleware('auth');
    }

    /**
     * List all results for an assessment
     *
     * @param  int  $assessment_id
     * @return
     */
    public function list($assessment_id)
    {
        $results = Result::where("assessment_id", $assessment_id)
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();

        return response($results);
    }

    /**
     * Show a results for result id with the parent assessment
     *
     * @param  int  $id
     * @return
     */
    public function show($id)
    {

        $result = Result::where('id', $id)->with('assessment')->get();

        return response()->json($result);
    }

    /**
     * Get the number of results for a given assessment id
     *
     * @param  int  $assessment_id
     * @return
     */
    public function getResultCount($assessment_id)
    {

        $count = Result::where('assessment_id', $assessment_id)->get()->count();

        return response($count);
    }

    /**
     * update a result for a given id
     *
     * @param  int  $assessment_id
     * @return string
     */
    public function update(Request $request, $id)
    {

        $request->validate([
           'assessment_reason'=>'required',
           'assessment_result'=>'required'
        ]);

        $result = Result::find($id);

        if (empty($result)) {
            return "result id " . $id . " can't be found";
        } else {
            $result->assessment_reason = $request->assessment_reason;
            $result->assessment_result = $request->assessment_result;
            $result->fuji_result = $request->fuji_result;

            $result->save();
            return "successful update: " . $id;

        }

    }

}
