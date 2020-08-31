<?php

namespace App\Http\Controllers;

use App\Truck;
use Illuminate\Http\Request;
use Validator;

class TrucksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = ['message' => 'empty', 'values' => 'empty'];

        $truck  = Truck::get();

        if (count($truck) > 0) {
            $res = ['message' => 'success', 'values' => $truck];
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
            $truck = Truck::create($request->all());
    
            if ($truck) {
                $res = ['message' => 'success input data', 'values' => $truck];
            } else {
                $res = ['message' => 'input failed', 'values' => 'empty'];
            }
    
            return response()->json($res, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $truck = Truck::find($id);
        
        if (!is_null($truck)) {
            $res = ['message' => 'success', 'values' => $truck];
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
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = $this->rule($request);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $truck = Truck::find($id);
            
            if (!is_null($truck) && $truck->update($request->all())) {
                $res = ['message' => 'success updating data', 'values' => $truck];
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
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        
        $truck = Truck::find($id);

        if (!is_null($truck) && $truck->delete()) {
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
            'model'   =>  'required|string|between:1,100',
            'plat_no' =>  'required|string|between:1,20',
        ];

        return Validator::make($request->all(), $rules);
    }

}
