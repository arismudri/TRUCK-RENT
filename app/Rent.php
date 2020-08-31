<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    protected $fillable = array('rent_code','truck_id','tgl');
}
