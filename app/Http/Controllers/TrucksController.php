<?php

namespace App\Http\Controllers;

use App\Truck;
use Illuminate\Http\Request;

class TrucksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res['message'] = 'empty';
        $res['values']  = '';

        $truck  = Truck::all();

        if (count($truck) > 0) {
            $res['message'] = 'success';
            $res['values']  = $truck;
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
        $res['message'] = 'input failed';
        $res['values']  = '';
        
        $model   = $request->model;
        $plat_no  = $request->plat_no;
        
        if (!empty($model) && !empty($plat_no)) {

            $save = Truck::create($request->all());
    
            if ($save) {
                $data = [   'model'    =>  $model,
                            'plat_no'  =>  $plat_no];
    
                $res['message'] = 'success input data';
                $res['values']  = $data;
            }
        }

        return response()->json($res, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res['message']  = 'empty';
        $res['values']  = '';

        if (!empty($id)) {
            
            $truck = Truck::where('id', $id)->get();

            if (count($truck) > 0) {
                $res['message']  = 'success';
                $res['values']  = $truck;
            }
        }

        return response()->json($res, 200);
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
        $res['message'] = 'update failed';
        $res['values']  = '';

        $model   = $request->model;
        $plat_no  = $request->plat_no;
        
        if (!empty($model) && !empty($plat_no) && !empty($id)) {

            $data = [   'model'    =>  $model,
                        'plat_no'  =>  $plat_no];
    
            $update = Truck::where('id', $id)->update($data);
    
            if ($update) {
                $res['message'] = 'success updating data';
                $res['values']  = $data;
            }
        }


        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res['message'] = 'delete failed';
        
        if (!empty($id)) {

            $del = Truck::destroy($id);
            
            if ($del) {
                $res['message'] = 'success deleting data';
            }
        }
        
        return response()->json($res, 200);
    }

}
