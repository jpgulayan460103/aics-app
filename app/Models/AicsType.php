<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AicsType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function requirements()
    {
        return $this->hasMany(AicsRequrement::class);
    }

    public function subtype()
    {
        return $this->hasMany(AicsTypeSubcategory::class);
    }
}
