<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violations extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'student_id',
        'title',
        'discipline',
    ];

    public function student(){
        return $this->belongsTo(Students::class , 'student_id');
    }
   
}
