<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Status;
use App\District;
use App\Department;
use Illuminate\Support\Facades\Auth;
use Validator;
class AdminController extends Controller
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
        $user = User::where('users.master', 0)->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'users.status_id', '=', 'statuses.id')
        ->leftJoin('departments', 'users.dept_id', '=', 'departments.id')
        ->leftJoin('users as tl', 'tl.id', '=', 'users.team_lead_id')
        ->select('users.*','roles.role','districts.district','statuses.status','departments.department','tl.name as team_lead')
        ->get();
        return response()->json([
			'success' => true,
			'data' => $user
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
			'role_id' => 'required',
			'dept_id' => 'required',
			'name' => 'required', 
			'email' => 'required|email|unique:users',
			'password' => 'required', 
			'mobile_no' => 'required|unique:users',
			'cnic' => 'required',
			'district_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}

		$input = $request->all(); 
		$input['master'] = 0;
		$input['password'] = bcrypt($input['password']); 
		$create = User::create($input); 
		//$token = $user->createToken('myApp')->accessToken; 
        $user = User::where('users.id', $create->id)->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'users.status_id', '=', 'statuses.id')
        ->leftJoin('departments', 'users.dept_id', '=', 'departments.id')
        ->leftJoin('users as tl', 'tl.id', '=', 'users.team_lead_id')
        ->select('users.*','roles.role','districts.district','statuses.status','departments.department','tl.name as team_lead')
        ->first();
		return response()->json([
			'success' => true,
			'data' => $user
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
        $user = User::where('users.id', $id)->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'users.status_id', '=', 'statuses.id')
        ->leftJoin('departments', 'users.dept_id', '=', 'departments.id')
        ->leftJoin('users as tl', 'tl.id', '=', 'users.team_lead_id')
        ->select('users.*','roles.role','districts.district','statuses.status','departments.department','tl.name as team_lead')
        ->get();

        return response()->json([
			'success' => true,
			'data' => $user
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
			'role_id' => 'required',
			'dept_id' => 'required',
			'name' => 'required', 
			'email' => 'required', 
			'mobile_no' => 'required',
			'cnic' => 'required',
			'district_id' => 'required'
		]); 
		if ($validator->fails()) { 

			return response()->json([
			'success' => false,
			'errors' => $validator->errors()
		
		]); 

		}

		$input = $request->all(); 
		$input['password'] = bcrypt($input['password']); 
		$update = User::where('id', $id)->update($input); 
        $user = User::where('users.id', $id)->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->leftJoin('districts', 'users.district_id', '=', 'districts.id')
        ->leftJoin('statuses', 'users.status_id', '=', 'statuses.id')
        ->leftJoin('departments', 'users.dept_id', '=', 'departments.id')
        ->leftJoin('users as tl', 'tl.id', '=', 'users.team_lead_id')
        ->select('users.*','roles.role','districts.district','statuses.status','departments.department','tl.name as team_lead')
        ->first();
		return response()->json([
			'success' => true,
			'data' => $user
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
        return (User::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'user has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'user cannot delete' ];
    }
}
