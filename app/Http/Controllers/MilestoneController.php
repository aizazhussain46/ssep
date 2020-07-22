<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Status;
use App\District;
use App\Department;
use App\Job;
use App\Milestone;
use Illuminate\Support\Facades\Auth;
use Validator;
class MilestoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('register','login','logout');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();        
        $validator = Validator::make($request->all(), [ 
			'milestone_title' => 'required',
			'description' => 'required',
			'duration' => 'required',
            'job_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}
        
        $input = $request->all();
        $input["created_by"] = $user->id;
        $input["status_id"] = 1;
		$create = Milestone::create($input); 
        $milestone = Milestone::where('milestones.id', $create->id)
        ->leftJoin('users', 'milestones.created_by', '=', 'users.id')
        ->leftJoin('jobs', 'milestones.job_id', '=', 'jobs.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('milestones.*','users.name','jobs.task_title','statuses.status')
        ->first();
		return response()->json([
			'success' => true,
			'data' => $milestone
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $milestone = Milestone::where('milestones.id', $id)
        ->leftJoin('users', 'milestones.created_by', '=', 'users.id')
        ->leftJoin('jobs', 'milestones.job_id', '=', 'jobs.id')
        ->leftJoin('statuses', 'milestones.status_id', '=', 'statuses.id')
        ->select('milestones.*','users.name','jobs.task_title','statuses.status')
        ->get();
		return response()->json([
			'success' => true,
			'data' => $milestone
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {     
        $validator = Validator::make($request->all(), [ 
			'milestone_title' => 'required',
			'description' => 'required',
			'duration' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}
        
        $input = $request->all();
		$create = Milestone::where('id', $id)->update($input); 
        $milestone = Milestone::where('milestones.id', $id)
        ->leftJoin('users', 'milestones.created_by', '=', 'users.id')
        ->leftJoin('jobs', 'milestones.job_id', '=', 'jobs.id')
        ->leftJoin('statuses', 'milestones.status_id', '=', 'statuses.id')
        ->select('milestones.*','users.name','jobs.task_title','statuses.status')
        ->first();
		return response()->json([
			'success' => true,
			'data' => $milestone
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return (Milestone::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'Milestone has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'Milestone cannot delete' ];
    }
    public function milestones_by_job($id)
    {
        $milestone = Milestone::where('milestones.job_id', $id)
        ->leftJoin('users', 'milestones.created_by', '=', 'users.id')
        ->leftJoin('jobs', 'milestones.job_id', '=', 'jobs.id')
        ->leftJoin('statuses', 'milestones.status_id', '=', 'statuses.id')
        ->select('milestones.*','users.name','jobs.task_title','statuses.status')
        ->get();
		return response()->json([
			'success' => true,
			'data' => $milestone
        ],200);
    }
}
