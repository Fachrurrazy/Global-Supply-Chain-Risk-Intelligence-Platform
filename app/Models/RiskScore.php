<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    protected $fillable = ['country_code', 'score', 'label', 'details'];
    protected $casts = ['details' => 'array'];
}
