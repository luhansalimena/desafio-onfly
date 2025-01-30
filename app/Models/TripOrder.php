<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripOrder extends Model
{
    /** @use HasFactory<\Database\Factories\TripOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'from',
        'to',
        'trip_date',
        'trip_return_date',
        'user_id'
    ];
}
