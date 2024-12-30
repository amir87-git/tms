<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'vehicle_typ',
        'vehicle_no',
        'trailer_no',
        'str_mtr_rdng',
        'end_mtr_rdng',
        'fuel',
        'status',
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function driver()
    {
        return $this->hasMany(Driver::class);
    }

    use HasFactory;
}
