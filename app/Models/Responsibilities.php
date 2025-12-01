<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsibilities extends Model
{
     protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'date'
    ];
}
