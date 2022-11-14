<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AicsDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_directory',
        'aics_requrement_id',
        'aics_assistance_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
        self::updating(function($model) {

        });
    }

    public function requirement()
    {
       return $this->belongsTo(AicsRequrement::class,"aics_requrement_id");
    }
    
}
