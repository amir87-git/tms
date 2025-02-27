<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';
    protected $primaryKey = 'id';

    protected $fillable = [
        'shipment_id',
        'location',
        'in_date',
        'in_time',
        'out_date',
        'out_time',
        'total_time',
    ];

    // Define the relationship with the Shipment model
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    
}
