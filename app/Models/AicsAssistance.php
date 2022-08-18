<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AicsAssistance extends Model
{
    use HasFactory;

    protected $fillable = [
        'aics_client_id',
        'aics_beneficiary_id',
        'aics_type_id',
        'sub_type',
        'status',
        'status_date',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
            $model->status = "Pending";
            $model->status_date = Carbon::now();
        });
        self::updating(function($model) {

        });
    }

    public function aics_client()
    {
        return $this->belongsTo(AicsClient::class);
    }

    public function aics_beneficiary()
    {
        return $this->belongsTo(AicsBeneficiary::class);
    }

    public function aics_type()
    {
        return $this->belongsTo(AicsType::class);
    }

    public function aics_documents()
    {
        return $this->hasMany(AicsDocument::class);
    }
}
