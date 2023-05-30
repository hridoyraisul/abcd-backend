<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'user_id',
        'status',
    ];

    public function student(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function checkAttendance($student_id): bool
    {
        return Attendance::query()
            ->where('student_id', $student_id)
            ->where('created_at', date('Y-m-d'))
            ->exists();
    }
    public static function checkAttendanceByDate($student_id, $date): bool
    {
        return Attendance::query()
            ->where('student_id', $student_id)
            ->whereDay('created_at', $date)
            ->exists();
    }
    public static function getAttendance($student_id)
    {
        return Attendance::query()
            ->where('student_id', $student_id)
            ->where('created_at', date('Y-m-d'))
            ->first();
    }
}
