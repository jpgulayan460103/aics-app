<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServedClientsMeta extends Model
{
    use HasFactory;
  
    protected $fillable = ['served_client_id', 'key', 'value'];
}
