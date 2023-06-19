<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirtyList extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes ;
    protected $guarded = ['id']; 
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['aics_clients'];


    public function getFileDirectoryAttribute($value)
    {
        return url($value);
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(Config::get('app.timezone'))->toDateTimeString();
    }

    public function aics_clients()
    {
        return $this->hasMany(AicsClient::class);

    }
}
