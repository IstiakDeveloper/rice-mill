<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;


class Bag extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'bag_amount',
        'bag_size',
        'per_bag_price',
        'total',
        'date',
    ];

    public static $rules = [
        'bag_amount' => 'numeric',
        // other validation rules for other attributes
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
