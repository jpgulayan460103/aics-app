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
    

   
}
