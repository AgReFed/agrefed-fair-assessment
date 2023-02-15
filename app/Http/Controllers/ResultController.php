<?php

namespace App\Http\Controllers;

//use App\Models\Assessment;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{

    public function __construct()
    {
        // all routes limited to logged in users
        //$this->middleware('auth');
    }

    public function list($assessment_id)
    {
        // list results for an assessment
        $results = Result::where("assessment_id", $assessment_id)
            ->orderBy('id', 'ASC')
            ->get()
            ->toArray();

        return response($results);
    }

    public function show($id)
    {
//        $result = Result::with(array('assessment'=>function($query){
//            $query->select('id', 'name', 'description');
//        }))->where('id', $id)->get();

        $result = Result::where('id', $id)->with('assessment')->get();

        //return response($result);
        return response()->json($result);
    }

    public function getUnsubmittedResult($assessment_id)
    {
        // list results for an assessment
        $result = Result::where(
            ["assessment_id" => $assessment_id,
            "submitted" => false
            ])
            ->first();

        // result json if an unsubmitted assess.result was found, otherwise null
        return response($result);
    }

    public function getResultCount($assessment_id)
    {

        $count = Result::where('assessment_id', $assessment_id)->get()->count();

        return response($count);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = Result::find($id);
        return response()->$result;
    }

    public function update(Request $request, $id)
    {
//        $data = $request->all();

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
