<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';
    protected $primaryKey = 'id';

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'client_name',
        'email',
        'phone',
        'type',
        'description',
        'status',
        'driver_id',
        'vehicle_id',
        'trailer_no',
        'start_time',
        'end_time',
        'overall_time',
        'total_km',
        'fuel',
        'qty',
        'mrktng_persnl',
        'highway_chrg',
        'trnsprt_chrg',
        'heldUp_hrs',
        'rate_perHr',
        'heldUp_chrg',
        'total_amnt',
    ];

    /**
     * Relationship: Shipment belongs to a Driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    /**
     * Relationship: Shipment belongs to a Vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'shipment_id');
    }

}
