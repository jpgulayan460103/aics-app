<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DirtyList extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    public function getFileDirectoryAttribute($value)
    {
        return url($value);
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(Config::get('app.timezone'))->toDateTimeString();
    }
}
