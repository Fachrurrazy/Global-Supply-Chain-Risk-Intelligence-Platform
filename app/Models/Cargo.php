<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = [
        'resi_number',
        'item',
        'vessel',
        'route',
        'current_lat',
        'current_lng',
        'standard_eta',
    ];
}
