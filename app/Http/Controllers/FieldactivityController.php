<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fieldactivity;
use Illuminate\Support\Facades\Auth;
use Validator;
class FieldactivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
	}
    
    public function index()
    {
        $activity = Fieldactivity::orderBy('id','desc')->get();
        return $activity;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'activity_name' => 'required',
            'DO_name' => 'required',
            'district' => 'required',
            ]); 
		if ($validator->fails()) { 

			return response()->json([ 'success' => false, 'errors' => $validator->errors() ],201); 
        }

        $attachment = asset('uploads/attachments/no-img.png');
        $attach = $request->images;
        
        if(!empty($attach)){
            $attachment = array();
        
        foreach($attach as $image){
            
            $ext = $image['extension'];
            $filename = 'attach_'.uniqid().'.'.$ext;
            
            $ifp = fopen( public_path('uploads/attachments/'.$filename), 'wb' ); 
            fwrite( $ifp, base64_decode($image['image']));
            fclose( $ifp );
            $attachment[] = asset('uploads/attachments/'.$filename); 
        }        
        }

        $att_arr = asset('uploads/attachments/no-img.png');
        $attendance = $request->attendance_sheet;
        if(!empty($attendance)){
            $att_arr = array();
        
        foreach($attendance as $att){
            
            $ext = $att['extension'];
            $filename = 'attach_'.uniqid().'.'.$ext;
            
            $ifp = fopen( public_path('uploads/attachments/'.$filename), 'wb' ); 
            fwrite( $ifp, base64_decode($att['image']));
            fclose( $ifp );
            $att_arr[] = asset('uploads/attachments/'.$filename); 
        }        
        }
        // echo "<pre>";
        // print_r($attachment);
        // die;
        $fields = [
            'date' => $request->date,
            'activity_name' => $request->activity_name,
            'district' => $request->district,
            'uc' => $request->uc,
            'taluka' => $request->taluka,
            'village' => $request->village,
            'DO_name' => $request->DO_name,
            'count_participants' => $request->count_participants,
            'male' => $request->male,
            'female' => $request->female,
            'details' => $request->details,
            'images' => $attachment,
            'attendance_sheet' => $att_arr,
            'user_id' => Auth::id(),
            'map_lat' => $request->map_lat,
            'map_long' => $request->map_long,
            'map_location' => $request->map_location,
        ];

        $created = Fieldactivity::create($fields);
        if ($created) {
            return response()->json([ 'success' => true, 'data' => $created ],200); 
        } else {
            return response()->json([ 'success' => false, 'data' => '' ],201); 
        }
    }

    public function show($id)
    {
        $activity = Fieldactivity::find($id);
        return $activity;
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
