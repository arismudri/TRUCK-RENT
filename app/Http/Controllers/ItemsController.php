<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
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

        $item  = Item::all();

        if (count($item) > 0) {
            $res['message'] = 'success';
            $res['values']  = $item;
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
        
        $nama   = $request->nama;
        $berat  = $request->berat;
        $jumlah = $request->jumlah;
        
        if (!empty($nama) && !empty($berat) && !empty($jumlah)) {

            $save = Item::create($request->all());
    
            if ($save) {
                $data = [ 'nama'    =>  $nama,
                          'berat'   =>  $berat,
                          'jumlah'  =>  $jumlah ];
    
                $res['message'] = 'success input data';
                $res['values']  = $data;
            }
        }

        return response()->json($res, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res['message']  = 'empty';
        $res['values']  = '';

        if (!empty($id)) {
            
            $item = Item::where('id', $id)->get();

            if (count($item) > 0) {
                $res['message']  = 'success';
                $res['values']  = $item;
            }
        }

        return response()->json($res, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res['message'] = 'update failed';
        $res['values']  = '';

        $nama   = $request->nama;
        $berat  = $request->berat;
        $jumlah = $request->jumlah;
        
        if (!empty($nama) && !empty($berat) && !empty($jumlah) && !empty($id)) {

            $data = [ 'nama'    =>  $nama,
                      'berat'   =>  $berat,
                      'jumlah'  =>  $jumlah ];
    
            $update = Item::where('id', $id)->update($data);
    
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
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res['message'] = 'delete failed';
        
        if (!empty($id)) {

            $del = Item::destroy($id);
            
            if ($del) {
                $res['message'] = 'success deleting data';
            }
        }
        
        return response()->json($res, 200);
    }

}
