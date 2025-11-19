<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsCondition extends Model
{
    use HasFactory;

     protected $table="terms_conditions";
    protected $primaryKey="id";


    public function gettype()
    {
        return $this->hasOne(DeliveryType::class, 'id', 'type_id'); // Adjust the foreign key and local key as necessary
    }
}
