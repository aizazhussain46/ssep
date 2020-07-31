<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
   
    public function index()
    {
        $users = User::orderBy('id','DESC')->get();
        foreach($users as $user){
            $user->role =  $user->role;
            $user->department = $user->department;
            $user->district =  $user->district;
            $user->status =  $user->status;
        }     
        
        return response()->json([ 'success' => true,'data' => $users] ,200);
    }

  
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'role_id' => 'required',
			'department_id' => 'required',
			'name' => 'required', 
			'email' => 'required|email|unique:users',
			'password' => 'required', 
			'mobile_no' => 'required|unique:users',
			'cnic' => 'required',
			'district_id' => 'required'
		]); 
		if ($validator->fails()) { 
			return response()->json([ 'success' => false, 'errors' => $validator->errors() ]); 
        }
        
        $arr = [
            'role_id' => $request->role_id, 
            'department_id' => $request->department_id, 
            'master' => 0, 
            'email' => $request->email, 
            'password' => bcrypt($request->password), 
            'name' => $request->name,   
            'mobile_no' => $request->mobile_no, 
            'cnic' =>  $request->cnic, 
            'isActive' => $request->isActive, 
            'district_id' => $request->district_id
        ];

        $created = User::create($arr);
       
        if($created){
            
            $created->user = $created->user;
            $created->role = $created->role;
            $created->department = $created->department;
            $created->status = $created->status;
            $created->district = $created->district;
            return response()->json(['success' => true, 'data' => $created]);
        }
        else{
            return response()->json(['success' => false,'data' => '']);
        }
        
    }


    public function update(Request $request, $id)
    {
        $arr = [
            'role_id' => $request->role_id, 
            'department_id' => $request->department_id, 
            'master' => 0, 
            'email' => $request->email, 
            'name' => $request->name,   
            'mobile_no' => $request->mobile_no, 
            'cnic' =>  $request->cnic, 
            'isActive' => $request->isActive, 
            'district_id' => $request->district_id
        ];

        $updated = User::where('id',$id)->update($arr);
       
        if($updated){

            $user = User::find($id);
            
            $user->user = $user->user;
            $user->role = $user->role;
            $user->department = $user->department;
            $user->status = $user->status;
            $user->district = $user->district;

            return response()->json(['success' => true, 'data' => $user]);
        }
        else{
            return response()->json(['success' => false,'data' => '']);
        }
    }

    public function change_password(Request $request,$id)
    {
        $response = false;
        $update = User::where('id', $id)->update(['password' => bcrypt($request->change_password)]);
        $response = ($update) ?  true : false ;
        return response()->json(['success' => $response] );
    }

   
    public function destroy($id)
    {
        return (User::find($id)->delete()) 
                ? [ 'response_status' => true, 'message' => 'user has been deleted' ] 
                : [ 'response_status' => false, 'message' => 'user cannot delete' ];
    }
}
