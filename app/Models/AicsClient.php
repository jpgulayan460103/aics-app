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
        'assessment',
        'interviewed_by',        
        'subcategory_others',
        'category_id',
        'subcategory_id',
        'age',
        'gender',
        'occupation',
        'monthly_salary',
        'payroll_id',
        'aics_type_id',
        'status',
        'date_claimed',
        'civil_status',
        'mode_of_admission',
        'dirty_list_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::updating(function($model) {
            if($model->payroll_id){
                $model->dirty_list_id = null;
            }
        });
    }


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function aics_type()
    {
        return $this->belongsTo(AicsType::class);
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
