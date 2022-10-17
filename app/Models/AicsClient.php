<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AicsClient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'ext_name',
        'street_number',
        'psgc_id',
        'mobile_number',
        'birth_date',
        'rel_beneficiary',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }

    public function aics_beneficiaries()
    {
        return $this->hasMany(AicsBeneficiary::class);
    }

    public function aics_assistances()
    {
        return $this->hasMany(AicsAssistance::class);
    }
    
}
