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
        // $this->middleware('auth:api');
	}
  
    public function index()
    {

        $jobs = Job::orderBy('id', 'DESC')->get();
		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function jobs_by_created_user($id)
    {

        $jobs = Job::orderBy('id', 'DESC')->where('created_by',$id)->get();

		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function jobs_by_assigned_user($id)
    {

        $jobs = Job::orderBy('id', 'DESC')->where('assigned_to',$id)->get();

		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function btl_records()
    {

        $jobs = Job::orderBy('id', 'DESC')->where('job_type',2)->get();

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

        list($status,$data) = $created ? [ true , $created] : [ false , ''] ;

        return response()->json(['success' => $status, 'data' => $data]);
        
    }

    public function show($id)
    {
		return response()->json([ 'success' => true, 'data' => Job::where('id', $id)->first() ]);
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

        list($status,$data) = $updated ? [ true , Job::find($id) ] : [ false , ''] ;

        return response()->json(['success' => $status, 'data' => $data]);

    }

    public function update_attachment(Request $request, $id)
    {
        $attachment = '';

        if($request->hasFile('attachment')){
           $attachment = $request->attachment->getClientOriginalName();
           $request->attachment->move(public_path('uploads/attachments/'),$attachment);
           $attachment = asset('uploads/attachments/' . $attachment);
        }
        else{ $attachment = Job::find($id)->attachment; }
        
        $updated = Job::where('id', $id)->update(['attachment' => $attachment]); 

        list($status,$data) = $updated ? [ true , Job::find($id)->attachment ] : [ false , ''] ;

        return response()->json(['success' => $status, 'attachment' => $data]);

    }

    public function destroy($id)
    {
        return (Job::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'Job has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'Job cannot delete' ] ;
    }
}
