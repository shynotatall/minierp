<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'total_amount',
    ];

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}
