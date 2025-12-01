<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $primaryKey = 'id';
   
    protected $fillable = [
        'student_id',
        'food_payment',
        'housing_payment',
        'totle_payment',
        'payment_month',
    ];

    public function student(){
        return $this->belongsTo(Students::class , 'student_id');
    }
    
}
