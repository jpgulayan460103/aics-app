<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AicsType extends Model
{
    use HasFactory;

    public function requirements()
    {
        return $this->hasMany(AicsRequrement::class);
    }
}
