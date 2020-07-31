<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys = Survey::orderBy('id', 'DESC')->get();

        foreach($surveys as $survey){
            $survey->user = $survey->user;
            $survey->district = $survey->district;
            $survey->job = $survey->job;
            $survey->fms = json_decode($survey->fms);
            
        }
		return response()->json([ 'success' => true, 'data' => $surveys ] ,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $s = Survey::create(['user_id' => 1,'survey_field' => json_encode($request->all())]);
        // return $s ? 200 : 201;
        // die;
        $arr = [
            'name' => $request->name,
            'address' => $request->address,
            'pn' => $request->pn,
            'or' => $request->or,
            'lot' => $request->lot,
            'rooms'  => $request->rooms,
            'fms' => $request->fms,
            'nprw' => $request->nprw,
            'distance' => $request->distance,
            'occupation' => $request->occupation,
            'gi' => $request->gi,
            'expenditures' => $request->expenditures,
            'farm_size' => $request->farm_size,
            'amount' => $request->amount,
            'price_kwh' => $request->price_kwh,
            'peak_hours' => $request->peak_hours,
            'reliability' => $request->reliability,
            'fan' => $request->fan,
            'fan_hours' => $request->fan_hours,
            'ac' => $request->ac,
            'ac_hours' => $request->ac_hours,
            'computers' => $request->computers,
            'computer_hours' => $request->computer_hours,
            'refrigerator' => $request->refrigerator,
            'refrigerator_hours' => $request->refrigerator_hours,
            'savers' => $request->savers,
            'saver_hours' => $request->saver_hours,
            'machine' => $request->machine,
            'machine_hours' => $request->machine_hours,
            'tv' => $request->tv,
            'tv_hours' => $request->tv_hours,
            'other' => $request->other,
            'other_hours' => $request->other_hours,
            'feedback' => $request->feedback,
            'user_id' => $request->user_id,
            'job_id' => $request->job_id,
            'district_id' => $request->district_id
        ];
    //    echo json_encode($arr);
    //    die;
        $created = Survey::create($arr);


        return response()->json([
			'status_code' => $created ? 200 : 201
		]); 

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::find($id);
        $survey->user = $survey->user;
        $survey->district = $survey->district;
        $survey->job = $survey->job;
        $survey->fms = json_decode($survey->fms);   
        return $survey;
    }


}
