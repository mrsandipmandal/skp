<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Signup extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "main_signup";
    // protected $primaryKey = "sl";

    // public function getSalon()
    // {
    //     return $this->hasOne(Salon::class, 'sid', 'username'); // Adjust the foreign key and local key as necessary
    // }

    // public function getWorker()
    // {
    //     return $this->hasOne(Worker::class, 'wid', 'username'); // Adjust the foreign key and local key as necessary
    // }

    // public function getCustomer()
    // {
    //     return $this->hasOne(Customer::class, 'cid', 'username'); // Adjust the foreign key and local key as necessary
    // }
}
