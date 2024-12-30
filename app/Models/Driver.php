<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Use Authenticatable instead of Model
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Driver extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'drivers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'helper',
        'status',
    ];

    /**
     * Hash the password before creating or updating.
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($driver) {
            if ($driver->isDirty('password')) {
                $driver->password = Hash::make($driver->password);
            }
        });
    }

    /**
     * Relationships
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class); // Assuming `Trip` is the correct model here
    }

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class);
    }
}
