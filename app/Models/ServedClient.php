<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        Log::info('inside booot');

        static::creating(function ($model) {
            $psgc = Psgc::where('brgy_psgc', $model->psgc)->first();
            $model->psgc_id = $psgc->id;
            $model->meta_last_name = metaphone($model->last_name);
            $model->meta_first_name = metaphone($model->first_name);
            $model->meta_middle_name = metaphone($model->middle_name);
            $model->full_name = $model->first_name . " " . $model->middle_name . " " . $model->last_name . " " . $model->ext_name;
            $model->meta_full_name = metaphone($model->first_name) . metaphone($model->middle_name) . metaphone($model->last_name);
            Log::info('Creating end');
        });
        self::updating(function ($model) {
            $psgc = Psgc::where('brgy_psgc', $model->psgc)->first();
            $model->psgc_id = $psgc->id;
            $model->meta_last_name = metaphone($model->last_name);
            $model->meta_first_name = metaphone($model->first_name);
            $model->meta_middle_name = metaphone($model->middle_name);
            $model->full_name = $model->first_name . " " . $model->middle_name . " " . $model->last_name . " " . $model->ext_name;
            $model->meta_full_name = metaphone($model->first_name) . metaphone($model->middle_name) . metaphone($model->last_name);
        });
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }

    public function getEnteredDateTimeAttribute($date)
    {
        return $this->attributes['entered_datetime'] = Carbon::parse($date)->format('m-d-Y');
    }

      public function getAccomplishedDateAttribute($date)
    {
        return $this->attributes['accomplished_datetime'] = Carbon::parse($date)->format('m-d-Y');
    }


    public function getBirthDateAttribute($date)
    {
        return $this->attributes['birth_date'] = Carbon::parse($date)->toDateString();
    }
    public function getDateClaimedAttribute($date)
    {
        return $this->attributes['date_claimed'] = Carbon::parse($date)->toDateString();
    }
    public function getAmountAttribute($amount)
    {
        return $this->attributes['amount'] = number_format($amount, 2);
    }

    public function served_client_metas()
    {
        return $this->hasMany(ServedClientsMeta::class);
    }
}
