<?php

namespace App\Http\Controllers;

use App\Rent;
use App\Item;
use App\Cargo;
use DB;

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

        $rent  = Rent::All();
        $rent  = $this->rentHasManyCargo($rent);

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
            $data_rent = [
                'rent_code' =>  $request->rent_code,
                'truck_id'  =>  $request->truck_id,
                'biaya'     =>  $request->biaya,
                'tgl'       =>  $request->tgl,
            ]; 
            $rent = Rent::create($data_rent);
            
            if ($rent) {
                $cargo = $this->store_cargo($request->item_id, $rent->id);
                $res = ['message' => 'success input rents & cargo data', 
                        'values' =>  [  'rent' => $rent, 
                                        'cargos' => $cargo]  
                    ];
            } else {
                $res = ['message' => 'input rent failed', 'values' => 'empty'];
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
            $cargo = Cargo::where('rent_id',$id)->get();
            if (is_null($cargo)) $cargo = 'empty'; 
            $data  = ['rent' => $rent, 'cargos' => $cargo];

            $res = ['message' => 'success', 'values' => $data];
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

    private function rentHasManyCargo($rent)
    {
        $data_rent = array();

        foreach ($rent as $k => $key) {
            $data_cargo = array();
            if (count($key->cargo)>0) {
                foreach ($key->cargo as $c => $cg) {
                    array_push($data_cargo, $cg->item_id);
                }
            } else {
                $data_cargo = ['values' => 'empty'];
            }
            $data_rent[$k] = [
                'rent_id' => $key->id,
                'rent_code' => $key->rent_code,
                'truck_id' => $key->truck_id,
                'biaya' => $key->biaya,
                'tgl' => $key->tgl,
                'item_id' => $data_cargo
            ];
        }

        return $data_rent;
    }

    function store_cargo($items_cargo, $rent_id)
    {
        // $items_cargo = $request->item_id;
        $response = array();
        foreach ($items_cargo as $c) {//rule_cargo
            $validator_cargo = $this->rule_cargo($c);
            if ($validator_cargo->fails()) {
                $response[$c] = $validator_cargo->errors();
            } else {
                $data_cargo = ['rent_id' => $rent_id, 'item_id' => $c];
                $cargo = Cargo::create($data_cargo);
                $response[$c] = $cargo;
            }
        }
        return $response;
    }

    function rule($request)
    {
        $rules = [
            'rent_code'  =>  'required|unique:rents|string|between:1,225',
            'truck_id' =>  'required|exists:App\Truck,id|integer|digits_between:1,20',
            'item_id' =>  'required|array',
            'biaya' =>  'required|integer|digits_between:1,11',
            'tgl' =>  'required|date',
        ];

        return Validator::make($request->all(), $rules);
    }

    function rule_cargo($cargo_id)
    {
        $rules = [
            'item_id' =>  'required|exists:App\Item,id|integer|digits_between:1,20',
        ];

        return Validator::make(['item_id' => $cargo_id], $rules);
    }
    

}
