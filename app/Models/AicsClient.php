<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AicsClient extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, LogsActivity;
    protected static $logOnlyDirty = true;
    //protected static $logFillable = true;
    protected static $submitEmptyLogs = false;

    protected $dates = ['deleted_at'];
    protected static $recordEvents = ['updated', 'deleted'];
    protected static $logAttributesToIgnore = ['*'];
    protected static $logAttributes = [
        'last_name',
        'first_name',
        'middle_name',    
        'full_name',
        'birth_date'   
    ];


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
        'aics_type_id',
        'civil_status',
        'mode_of_admission',
        'dirty_list_id',
        'meta_full_name',
        'full_name',
        'valid_id_presented'
    ];

    public $appends = ['name'];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->full_name = $model->first_name . " " . $model->middle_name . " " . $model->last_name . " " . $model->ext_name;
            $model->uuid = Str::uuid();
        });
        self::updating(function ($model) {
            $model->full_name = $model->first_name . " " . $model->middle_name . " " . $model->last_name . " " . $model->ext_name;
            $model->meta_full_name = metaphone($model->first_name) . metaphone($model->middle_name) . metaphone($model->last_name);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    public function user()
    {
        return $this->belongsTo(User::class,);
    }

    public function psgc()
    {
        return $this->belongsTo(Psgc::class);
    }

    public function aics_type()
    {
        return $this->belongsTo(AicsType::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function aics_beneficiaries()
    {
        return $this->hasMany(AicsBeneficiary::class);
    }

    public function aics_assistances()
    {
        return $this->hasMany(AicsAssistance::class);
    }

    public function payroll_client()
    {
        return $this->hasOne(PayrollClient::class, 'aics_client_id')->withTrashed();
    }

    public function new_payroll_client()
    {
        return $this->hasOne(PayrollClient::class, 'new_payroll_client_id')->withTrashed();
    }

    public function dirty_list()
    {
        return $this->belongsTo(DirtyList::class, 'dirty_list_id');
    }

    public function getNameAttribute()
    {
        return $this->causer->name ?? null;
    }
}
