<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;


class Payroll extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    protected $guarded = ["id"];

    public function clients()
    {
        return $this->hasMany(PayrollClient::class)->withTrashed();
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }
    

    public function aics_type()
    {
        return $this->belongsTo(AicsType::class);
    }

    public function aics_subtype()
    {
        return $this->belongsTo(AicsTypeSubcategory::class, "aics_type_subcategory_id" );
    }


   
}
