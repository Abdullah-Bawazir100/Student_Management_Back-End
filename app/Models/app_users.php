<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class app_users extends Model
{
    
    use HasApiTokens;
    
    protected $table = 'app_users';

    protected $fillable = [
        'user_email',
        'user_password',
        'user_role',
    ];

    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function student()
    {
        return $this->hasOne(Students::class, 'user_id');
    }
}
