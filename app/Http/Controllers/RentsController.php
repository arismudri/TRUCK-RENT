<?php

namespace App\Http\Controllers;

use App\Rent;
use Illuminate\Http\Request;
use Validator;

class RentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = ['message' => 'empty', 'values' => 'empty'];

        $rent  = Rent::get();

        if (count($rent) > 0) {
            $res = ['message' => 'success', 'values' => $rent];
        }
        return response()->json($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = $this->rule($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $rent = Rent::create($request->all());
    
            if ($rent) {
                $res = ['message' => 'success input data', 'values' => $rent];
            } else {
                $res = ['message' => 'input failed', 'values' => 'empty'];
            }
    
            return response()->json($res, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $rent = Rent::find($id);
        
        if (!is_null($rent)) {
            $res = ['message' => 'success', 'values' => $rent];
            return response()->json($res, 200);
        } else {
            $res = ['message' => 'empty', 'values' => 'empty'];
            return response()->json($res, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->rule($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $rent = Rent::find($id);
            
            if (!is_null($rent) && $rent->update($request->all())) {
                $res = ['message' => 'success updating data', 'values' => $rent];
                return response()->json($res, 200);
            } else {
                $res = ['message' => 'update failed', 'values' => 'empty'];
                return response()->json($res, 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        
        $rent = Rent::find($id);

        if (!is_null($rent) && $rent->delete()) {
            $res = ['message' => 'success delete data'];
            return response()->json($res, 200);
        } else {
            $res = ['message' => 'delete failed'];
            return response()->json($res, 404);
        }
    }

    function rule($request)
    {
        $rules = [
            'nama'  =>  'required|string|between:1,225',
            'berat' =>  'required|integer|digits_between:1,11',
            'jumlah' =>  'required|integer|digits_between:1,11',
        ];

        return Validator::make($request->all(), $rules);
    }

}
