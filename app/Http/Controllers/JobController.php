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
        $this->middleware('auth:api');
	}
  
    public function index()
    {

        $jobs = Job::orderBy('id', 'DESC')->get();

        foreach($jobs as $job){
            $job->created_by_user = $job->created_by_user;
            $job->assigned_to_user = $job->assigned_to_user;
            $job->department = $job->department;
            $job->status = $job->status;
            $job->district = $job->district;
        }
		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function btl_records()
    {

        $jobs = Job::orderBy('id', 'DESC')->where('job_type',2)->get();

        foreach($jobs as $job){
            $job->created_by_user = $job->created_by_user;
            $job->assigned_to_user = $job->assigned_to_user;
            $job->department = $job->department;
            $job->status = $job->status;
            $job->district = $job->district;
        }
		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [ 
            'job_type' => 'required',
            'task_title' => 'required',
			'nature_of_task' => 'required', 
			'deliverables' => 'required', 
			'from' => 'required',
			'to' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

        }

        $attachment = asset('uploads/attachments/no-img.png');

        if($request->hasFile('attachment')){
           $attachment = $request->attachment->getClientOriginalName();
           $request->attachment->move(public_path('uploads/attachments/'),$attachment);
           $attachment = asset('uploads/attachments/' . $attachment);
        }
        
        $arr = [
            'job_type' => $request->job_type,
            'task_title' => $request->task_title,
            'nature_of_task' => $request->nature_of_task,
            'brief' => $request->brief,
            'deliverables' => $request->deliverables,
            'created_by' => $request->created_by,
            'department_id' => $request->department_id,
            '_from' => $request->from,
            '_to' => $request->to,
            'district_id' => $request->district_id,
            'status_id' => 1,
            'attachment' => $attachment,
            'assigned_to' => $request->assigned_to

        ];
        
        $created = Job::create($arr);
       
        if($created){


            $created->created_by_user = $created->created_by_user;
            $created->assigned_to_user = $created->assigned_to_user;
            $created->department = $created->department;
            $created->status = $created->status;
            $created->district = $created->district;
            
            return response()->json(['success' => true, 'data' => $created]);
        }
        else{
            return response()->json(['success' => false,'data' => '']);
        }
        
    }

    public function show($id)
    {
        $job = Job::where('id', $id)->first();

        $job->created_by_user = $job->created_by_user;
        $job->assigned_to_user = $job->assigned_to_user;
        $job->department = $job->department;
        $job->status = $job->status;
        $job->district = $job->district;
        
		return response()->json([ 'success' => true, 'data' => $job ], 200);
    }

    



    public function update_job(Request $request, $id)
    {
        $attachment = '';

        if($request->hasFile('attachment')){
           $attachment = $request->attachment->getClientOriginalName();
           $request->attachment->move(public_path('uploads/attachments/'),$attachment);
           $attachment = asset('uploads/attachments/' . $attachment);
        }
        else{ $attachment = Job::find($id)->attachment; }

        $arr = [
            'job_type' => $request->job_type,
            'task_title' => $request->task_title,
            'nature_of_task' => $request->nature_of_task,
            'deliverables' => $request->deliverables,
            'brief' => $request->brief,
            'department_id' => $request->department_id,
            '_from' => $request->from,
            '_to' => $request->to,
            'district_id' => $request->district_id,
            'assigned_to' => $request->assigned_to,
            'attachment' => $attachment
        ];
        
        $updated = Job::where('id', $id)->update($arr); 

        if($updated){

            $job = Job::find($id);

            $job->created_by_user = $job->created_by_user;
            $job->assigned_to_user = $job->assigned_to_user;
            $job->department = $job->department;
            $job->status = $job->status;
            $job->district = $job->district;
    
            return response()->json([ 'success' => true, 'data' => $job ]);
        }
        else{
            return response()->json([ 'success' => false,'data' => '' ]);
        }
    }

    public function destroy($id)
    {
        return (Job::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'Job has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'Job cannot delete' ] ;
    }
}
