<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServedClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'entered_datetime',
        'entered_by',
        'client_number',
        'accomplished_datetime',
        'psgc',
        'last_name',
        'first_name',
        'middle_name',
        'ext_name',
        'meta_last_name',
        'meta_first_name',
        'meta_middle_name',
        'sex',
        'civil_status',
        'birth_date',
        'age',
        'mode_of_admission',
        'type_of_assistance',
        'amount',
        'source_of_fund',
        'client_category',
        'charging',
        'mode_of_assistance',
        'date_claimed',
        'uuid',
    ];

    protected $dates = [
        'entered_datetime',
        'accomplished_datetime',
        'birth_date',
        'date_claimed',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $psgc = Psgc::where('brgy_psgc', $model->psgc)->first();
            $model->psgc_id = $psgc->id;
            $model->meta_last_name = metaphone($model->last_name);
            $model->meta_first_name = metaphone($model->first_name);
            $model->meta_middle_name = metaphone($model->middle_name);
        });
        self::updating(function($model) {
            $psgc = Psgc::where('brgy_psgc', $model->psgc)->first();
            $model->psgc_id = $psgc->id;
            $model->meta_last_name = metaphone($model->last_name);
            $model->meta_first_name = metaphone($model->first_name);
            $model->meta_middle_name = metaphone($model->middle_name);
        });
    }
}
