<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'description',
    ];

    public function student(){
        return $this->belongsTo(Students::class , 'student_id');
    }
   
}
