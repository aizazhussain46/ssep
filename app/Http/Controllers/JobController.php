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
        $user = Auth::user();
        $prev_job = Job::where(['status_id'=>1, 'dept_id'=>$user->dept_id])->first();
        if($prev_job){
        
        $validator = Validator::make($request->all(), [ 
			'task_title' => 'required',
			'nature_of_task' => 'required', 
			'brief' => 'required',
			'deliverables' => 'required', 
			'from' => 'required',
			'to' => 'required',
			'district_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}
        
        $input = $request->all();
        $input["created_by"] = $user->id;
        $input["dept_id"] = $user->dept_id;
        $input["status_id"] = 1;
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
    else{
        return response()->json([
			'success' => false,
			'msg' => "You have any unassigned job. kindly Assign it."
        ],200); 
    }
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
			'from' => 'required',
			'to' => 'required',
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

    public function pending_jobs()
    {
        $job = Job::where('jobs.status_id', 1)->leftJoin('users', 'jobs.created_by', '=', 'users.id')
        ->leftJoin('districts', 'jobs.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('jobs.*','users.name','districts.district','statuses.status')
        ->orderBy('jobs.id', "DESC")
        ->get();
		return response()->json([
			'success' => true,
			'data' => $job
		],200);
    }

    public function approve_job(Request $request, $id){
        $validator = Validator::make($request->all(), [ 
			'status_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}
		$input = $request->all(); 
		$update = Job::where('id', $id)->update($input); 
		
		return response()->json([
			'success' => true
		],200);
    }
    public function jobs_by_department()
    {
        $user = Auth::user();
        
        $job = Job::where(['jobs.status_id'=>6,'jobs.dept_id'=>$user->dept_id])->leftJoin('users', 'jobs.created_by', '=', 'users.id')
        ->leftJoin('districts', 'jobs.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'jobs.status_id', '=', 'statuses.id')
        ->select('jobs.*','users.name','districts.district','statuses.status')
        ->orderBy('jobs.id', "DESC")
        ->get();
		return response()->json([
			'success' => true,
			'data' => $job
		],200);
    }
}
