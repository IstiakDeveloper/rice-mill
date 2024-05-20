<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    protected $fillable = ['name',];

    public function bags()
    {
        return $this->hasMany(Bag::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
