<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function clients()
    {
        return $this->hasMany(AicsClient::class, "payroll_id")->orderBy('payroll_insert_at',"asc");;
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }

   
}
