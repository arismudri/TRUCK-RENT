<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = array('model','plat_no');

     function simpan($request)
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

        return $res;
    }
}
