<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
     * Create a new assessment and result
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
                                            'resource_name' => 'required'
                                        ]);

        $assessment = new Assessment;
        $assessment->user_id = Auth::id();
        $assessment->resource_name = $request->input('resource_name');
        $assessment->resource_description = $request->input('resource_description');
        $assessment->submitted = false;

        $assessment->save();

        $result = new Result([
                                 'assessment_reason' => $request->input('assessment_reason'),
                                 'assessment_version' => $request->input('assessment_version'),
                                 'assessment_result' => $request->input('assessment_results'),
                                 'fuji_result' => Null,
                                 'submitted' => false
                             ]);

        $assessment->results()->save($result);

        // return status and id of newly created assessment record
        return response()->json(array('success' => true, 'id' => $result->id, 'assessment_id' => $assessment->id), 200);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        // 'with' ensures that it retrieves the child records (= results) with the assessment
        $assessment = Assessment::where('id', $id)
            ->with([
                       'results' => function ($query) {
                           $query->orderBy('id', 'asc');
                       }
                   ])
            ->first();

        // check if user it authorised to view this assessment, returns 403
        Gate::authorize('get-assessment', $assessment);

        return response()->json($assessment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function edit($id, $result_id)
    {
        // with also retrieves the child record (= result) with the assessment
        $assessment = Assessment::where('id', $id)->with('results')->where('id', $result_id)->first();

        // check if requested assessment exists
        if (empty($assessment)) {
            abort(404, "Assessment doesn't exist");
        }

        // check if user it authorised to access this assessment, returns 403
        Gate::authorize('get-assessment', $assessment[0]);

        return response()->json($assessment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return
     */
    public function reassess($result_id)
    {
        $result = Result::find($result_id);

        // check if requested assessment exists
        if (empty($result)) {
            // if no result found, send to listing
            return redirect()->route('assessment_list');
        } else {
            $assessment = Assessment::find($result->assessment_id);

            // check if user it authorised to access this assessment, if not, send to listing
            if (Gate::denies('get-assessment', $assessment)) {
                return redirect()->route('assessment_list');
            }

            // reset flag (needs setting for both assessment and assessment result
            $assessment->submitted = false;
            $assessment->save();

        }

        $new_result = $result->replicate();

        $new_result->created_at = Carbon::now();
        $new_result->updated_at = null;
        $new_result->submitted = false;

        $new_result->save();
        $new_result_id = $new_result->id;

        return redirect()->route('getResultId', ['result_id' => $new_result_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
                                            'resource_name' => 'required',
                                        ]);

        // need to update both assessment and result tables
        $result = Result::find($request->input('result_id'));
        $assessment = Assessment::find($result->assessment_id);

        // check if user it authorised for this assessment, returns 403 if not
        Gate::authorize('get-assessment', $assessment);

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

}
