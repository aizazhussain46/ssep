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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Revision::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [ 
		// 	'role' => 'required'
		// ]); 
		// if ($validator->fails()) { 

		// 	return response()->json([
		// 	'success' => false,
		// 	'errors' => $validator->errors()
		// ]); 
        // }
        
        $arr = [
            's_id' => $request->s_id,
            'r_id' => $request->r_id,
            'job_id' => $request->job_id,
            'msg' => $request->msg,
        ];

        $created = Revision::create($arr);

        if($created){
            return response()->json(['success' => true, 'data' => $created]);
        }
        else{
            return response()->json(['success' => false, 'data' => '']);
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
        $revision = Revision::where('job_id', $id)->get();
        
		return response()->json([ 'success' => true, 'data' => $revision ], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
