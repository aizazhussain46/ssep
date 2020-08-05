<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Revision;
use Validator;

class RevisionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    
    public function index()
    {
        return Revision::all();
    }

    
     public function store(Request $request){
        

        $arr = [
            's_id' => $request->s_id,
            'r_id' => $request->r_id,
            'job_id' => $request->job_id,
            'msg' => $request->msg,
        ];

        $created = Revision::create($arr);

        if($created){
            return response()->json(['success' => true, 'data' => Revision::find($created->id)]);
        }
        else{
            return response()->json(['success' => false, 'data' => '']);
        }


    }

    public function revision_by_user(Request $request,$id)
    {
        $revisions = Revision::where('job_id',$id)
                             ->where([['s_id',$request->s_id],['r_id',$request->r_id]])
                             ->orWhere([['s_id',$request->r_id],['r_id',$request->s_id]])
                            // ->orderBy('id','DESC')
                             ->get();
        
		return response()->json([ 'success' => true, 'data' => $revisions ], 200);
    }
}
