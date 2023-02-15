<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Result;
use Carbon\Carbon;
use Carbon\Exceptions\BadComparisonUnitException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{

    public function __construct()
    {
        // all routes limited to logged in users
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assessments = Assessment::all()->toArray();
        return response(array_reverse($assessments));
    }

    public function list()
    {
        // list assessments for logged in user only
        $id = Auth::id();
        $assessments = Assessment::where("user_id", $id)
                                    ->orderBy('id', 'DESC')
                                    ->get()
                                    ->toArray();

        return response($assessments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //not used
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        // when user starts a new assessment
        $assessment = new Assessment;
        $assessment->user_id = $request->input('user_id');
        $assessment->resource_name = $request->input('resource_name');
        $assessment->resource_description = $request->input('resource_description');
        $assessment->submitted = false;

        $assessment->save();

        $result = new Result([
            'assessment_reason' => $request->input('assessment_reason'),
            'assessment_version' => $request->input('assessment_version'),
            'assessment_result' => json_encode($request->input('assessment_results')),
            'fuji_result' => json_encode($request->input('fuji_result')),
            'submitted' => false

        ]);

        $assessment->results()->save($result);

        // return status and id of newly created assessment record
       return response()->json(array('success' => true, 'id' => $result->id, 'assessment_id' => $assessment->id  ), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        // with ensures that it retrieves the child records (= results) with the assessment
        $assessment = Assessment::where('id', $id)
            ->with(['results' => function($query) {
                $query->orderBy('id', 'asc');
                }
            ])
        ->get();

        return response()->json($assessment[0]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $result_id)
    {
        // with also retrieves the child record (= result) with the assessment
        $assessment = Assessment::where('id', $id)->with('results')->where('id',$result_id);

        return response()->json($assessment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return
     */
    public function reassess($result_id)
    {
        // with also retrieves the child record (= result) with the assessment
        $result = Result::find($result_id);

        //return $result;

        $new_result = $result->replicate();

        $new_result->created_at = Carbon::now();
        $new_result->updated_at = null;
        $new_result->fuji_result = null;
        $new_result->submitted = false;

        $new_result->save();
        $new_result_id = $new_result->id;

        return redirect()->route('getResultId', ['result_id' => $new_result_id]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // need to update both assessment and result tables

        $result = Result::find($request->input('result_id'));
        $assessment = Assessment::find($result->assessment_id);

        $assessment->resource_name = $request->input('resource_name');
        $assessment->resource_description = $request->input('resource_description');
        $assessment->submitted = $request->input('submitted');

        $assessment->save();

        $result->submitted = $request->input('submitted');
        $result->assessment_reason = $request->input('assessment_reason');
        $result->assessment_result = $request->input('assessment_results');
        $result->fuji_result = $request->input('fuji_result');

        $result->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // not used
    }
}
