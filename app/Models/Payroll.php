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
        return $this->hasMany(PayrollClient::class)->withTrashed();
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }
    

   
}
