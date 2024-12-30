<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Manager extends Authenticatable
{
    protected $table = 'managers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
    ];

    public static function boot()
    {
        parent::boot();

        // Hash the password before creating or updating
        static::saving(function ($manager) {
            if ($manager->isDirty('password')) { // Ensure only the password field is hashed
                $manager->password = Hash::make($manager->password);
            }
        });
    }

    use HasFactory, Notifiable;
}
