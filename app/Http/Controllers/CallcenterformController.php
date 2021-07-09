<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calcenterform;
use Illuminate\Support\Facades\Auth;
use Validator;
class CallcenterformController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
	}
    public function index()
    {
        $call = Calcenterform::orderBy('id','desc')->get();
        return $call;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_no' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'cnic' => 'required|unique:calcenterforms',
            'mobile_no' => 'required',
            'district' => 'required',
            ]);


        //   echo "<pre>";
        // print_r($attachment);
        // die;
// ========================

if ($validator->fails()) {

    return response()->json([ 'success' => false, 'errors' => $validator->errors() ],201);
}


// //  echo "<pre>";
// //     print_r($attach);
// //     echo "</pre>";
// //     die;



$att_arr = asset('uploads/attachments/no-img.png');
$attendance = $request->attachment;
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


// ============================



        $fields = [
            'form_no' => $request->form_no,
            'date' => $request->date,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic' => $request->cnic,
            'mobile_no' => $request->mobile_no,
            'district' => $request->district,
            'uc' => $request->uc,
            'taluka' => $request->taluka,
            'village' => $request->village,
            'n_landmark' => $request->n_landmark,
            'address' => $request->address,
            'male_count' => $request->male_count,
            'female_count' => $request->female_count,
            'children_count' => $request->children_count,
            'source_of_info' => $request->source_of_info,
            'electricity' => $request->electricity,
            'loadshedding_hours' => $request->loadshedding_hours,
            'mocrofinanceload' => $request->mocrofinanceload,
            'mfi' => $request->mfi,
            'user_id' => Auth::id(),
            'attachment' => $att_arr,
            'map_lat' => $request->map_lat,
            'map_long' => $request->map_long,
            'map_location' => $request->map_location,
        ];

        $created = Calcenterform::create($fields);
        if ($created) {
            return response()->json([ 'success' => true, 'data' => $created ],200);
        } else {
            return response()->json([ 'success' => false, 'data' => '' ],201);
        }
    }

    public function show($id)
    {
        $call = Calcenterform::find($id);
        return $call;
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
