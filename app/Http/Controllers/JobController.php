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
    // 

    public function jobs_for_pmu()
    {

        $jobs = Job::orderBy('id', 'DESC')->whereIn('status_id',[1,2,3,4,6,7,8,9,10])->get();

		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function jobs_for_client()
    {

        $jobs = Job::orderBy('id', 'DESC')->where('status_id',10)->get();

		return response()->json([ 'success' => true, 'data' => $jobs ] ,200);
    }

    public function jobs_by_created_and_assigned($id)
    {

        $jobs = Job::orderBy('id', 'DESC')->where('created_by',$id)->orWhere('assigned_to',$id)->get();

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
            'status_id' => 8,
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

    public function get_job_count($id = null)
    {        
		return $id ? Job::where('job_type', $id)->count() : Job::count();
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

        
        $request->job_type != 1 ? $request->department_id = null : $request->district_id = null ;

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

    public function change_status(Request $request, $id)
    {

        $data = '';
        $updated = Job::where('id', $id)->update(['status_id' =>  $request->sw ? 2 : 4]); 
        if($updated){
            $data = Job::find($id);
        }
        else{
            $data = array();
        }
        return response()->json(['success' => $updated ? true : false, 'data'=>$data]);
    }
    public function approve_reject($id, $action)
    {
        $data = '';
        if($action == 'a'){
            $updated = Job::where('id', $id)->update(['status_id' => 6]); 
        }
        else{
            $updated = Job::where('id', $id)->update(['status_id' => 5]); 
        }
        if($updated){
            $data = Job::find($id);
        }
        else{
            $data = array();
        }
        
        return response()->json(['success' => $updated ? true : false, 'data'=>$data]);
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

        return response()->json(['success' =>  $updated ? true : false, 'attachment' => $attachment]);

    }

    public function share(Request $request, $id)
    {
        $role_id = User::find($request->user_id)->role_id;

        $updated = Job::where('id', $id)->update(['status_id' => !$role_id ? 9 : 10]); 

        list($status,$data) = $updated ? [ true , Job::find($id) ] : [ false , ''] ;

        return response()->json(['success' => $status, 'data' => $data]);

    }

    public function destroy($id)
    {
        return (Job::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'Job has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'Job cannot delete' ] ;
    }
}
