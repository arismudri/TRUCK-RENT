<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = array('rent_code','truck_id','biaya','tgl');
    
    public function cargo()
    {
        return $this->hasMany('App\Cargo', 'rent_id', 'id');
    }
}
