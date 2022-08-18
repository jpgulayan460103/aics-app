<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AicsRequrement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'aics_type_id',
        'is_required',
    ];
}
