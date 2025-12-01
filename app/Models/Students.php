<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'student_name',
        'student_phone',
        'student_university',
        'student_major',
        'student_city',
        'father_name',
        'father_phone',
        'skills'
    ];


    public static function storeStudentData(array $data, int $user_id):Students
    {
        // إنشاء مصفوفة بيانات الطالب
        $studentData = [
            'user_id' => $user_id,
            'student_name' => $data['student_name'],
            'student_phone' => $data['student_phone'],
            'student_university' => $data['student_university'],
            'student_major' => $data['student_major'],
            'student_city' => $data['student_city'],
            'father_name' => $data['father_name'],
            'father_phone' => $data['father_phone'],
            'skills' => $data['skills']
        ];


        // إنشاء سجل الطالب في قاعدة البيانات
        return self::create($studentData); // استخدام المتغير $studentData هنا لإنشاء السجل
    }

    public function user()
    {
        return $this->belongsTo(app_users::class, 'user_id');
    }

    public function payments(){
        return $this->hasMany(Payments::class , 'student_id');
    }

    public function violations(){
        return $this->hasMany(Violations::class , 'student_id');
    }

    public function complaints(){
        return $this->hasMany(Complaints::class , 'student_id');
    }

}
