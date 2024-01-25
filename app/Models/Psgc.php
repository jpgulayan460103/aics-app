<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psgc extends Model
{
    use HasFactory;

    public static function getRegions()
    {
        $instance = new static;
        return $instance->select('region_psgc','region_name')->where("region_name_short","XI")->distinct()->get();
    }

    public static function getBrgys($field, $value)
    {
        $instance = new static;
        return $instance->where($field, $value)->distinct()->get();
    }
}
