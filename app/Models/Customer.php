<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bag;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'area',
        'phone_number',
        'image',
        'season_id'
    ];

    public function bags()
    {
        return $this->hasMany(Bag::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
