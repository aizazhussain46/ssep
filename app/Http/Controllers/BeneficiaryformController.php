<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beneficiaryreferralform;
use Illuminate\Support\Facades\Auth;
use Validator;
class BeneficiaryformController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
	}
    public function index()
    {
        $beneficiary = Beneficiaryreferralform::orderBy('id','desc')->get();
        return $beneficiary;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name' => 'required',
            'name' => 'required',
            'father_name' => 'required',
            'cnic' => 'required|unique:calcenterforms',
            'mobile_no' => 'required',
            'district' => 'required',
            ]);
		if ($validator->fails()) {

			return response()->json([ 'success' => false, 'errors' => $validator->errors() ]);
        }

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


        $fields = [
            'name' => $request->name,
            'father_name' => $request->father_name,
            'cnic' => $request->cnic,
            'mobile_no' => $request->mobile_no,
            'district' => $request->district,
            'taluka' => $request->taluka,
            'village' => $request->village,
            'activity_event' => $request->activity_event,
            'supplier_name' => $request->supplier_name,
            'user_id' => Auth::id(),
            'attachment' => $att_arr,
            'map_lat' => $request->map_lat,
            'map_long' => $request->map_long,
            'map_location' => $request->map_location,
        ];

        $created = Beneficiaryreferralform::create($fields);
        if ($created) {
            return response()->json([ 'success' => true, 'data' => $created ],200);
        } else {
            return response()->json([ 'success' => false, 'data' => '' ],201);
        }
    }

    public function show($id)
    {
        $beneficiary = Beneficiaryreferralform::find($id);
        return $beneficiary;
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
