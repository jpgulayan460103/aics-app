<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollClient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sequence',
        'aics_client_id',
        'payroll_id',
        'new_payroll_client_id',
        'status',
        'date_claimed',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            $latest_count = self::query()->where('payroll_id', $model->payroll_id)->orderBy('sequence', 'desc')->first();
            if($latest_count){
                $model->sequence = $latest_count->sequence + 1;
            }else{
                $model->sequence = 1;
            }
        });
        self::updating(function($model) {
            if($model->status == "claimed"){
                $model->date_claimed = Carbon::now();
            }else{
                $model->date_claimed = null;
            }
        });
    }

    public function aics_client()
    {
        return $this->belongsTo(AicsClient::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function new_payroll_client()
    {
        return $this->belongsTo(PayrollClient::class)->withTrashed();
    }
}
