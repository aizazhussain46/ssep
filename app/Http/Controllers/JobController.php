<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Status;
use App\District;
use App\Department;
use App\Job;
use Illuminate\Support\Facades\Auth;
use Validator;
class JobController extends Controller
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
        $job = Job::leftJoin('users', 'jobs.created_by', '=', 'users.id')
        ->leftJoin('districts', 'jobs.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('jobs.*','users.name','districts.district','statuses.status')
        ->get();
		return response()->json([
			'success' => true,
			'data' => $job
		],200);
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
        $validator = Validator::make($request->all(), [ 
			'task_title' => 'required',
			'nature_of_task' => 'required', 
			'brief' => 'required',
			'deliverables' => 'required', 
			'timelines' => 'required',
			'district_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}
        $user = Auth::user();
        $input = $request->all();
        $input["created_by"] = $user->id;
		$create = Job::create($input); 
		$job = Job::where('jobs.id', $create->id)->leftJoin('users', 'jobs.created_by', '=', 'users.id')
        ->leftJoin('districts', 'jobs.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('jobs.*','users.name','districts.district','statuses.status')
        ->first();
		return response()->json([
			'success' => true,
			'data' => $job
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
        $job = Job::where('jobs.id', $id)->leftJoin('users', 'jobs.created_by', '=', 'users.id')
        ->leftJoin('districts', 'jobs.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('jobs.*','users.name','districts.district','statuses.status')
        ->get();
		return response()->json([
			'success' => true,
			'data' => $job
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
			'task_title' => 'required',
			'nature_of_task' => 'required', 
			'brief' => 'required',
			'deliverables' => 'required', 
			'timelines' => 'required',
			'created_by' => 'required',
			'district_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}

		$input = $request->all(); 
		$update = Job::where('id', $id)->update($input); 
		$job = Job::where('jobs.id', $id)->leftJoin('users', 'jobs.created_by', '=', 'users.id')
        ->leftJoin('districts', 'jobs.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('jobs.*','users.name','districts.district','statuses.status')
        ->first();
		return response()->json([
			'success' => true,
			'data' => $job
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
        return (Job::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'Job has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'Job cannot delete' ];
    }
}
