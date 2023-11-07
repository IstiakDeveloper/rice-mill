<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoCharge extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'amount',
    ];
    protected $dates = ['date'];
}
