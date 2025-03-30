<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'code', 'download_count'];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    // Function to generate a unique certificate code
    public static function generateCode()
    {
        return strtoupper(uniqid('CERT-'));
    }

    // Function to fetch or create a certificate and increment download count
    public static function fetchOrCreateCertificate($studentId, $courseId)
    {
        $certificate = self::where('user_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        if ($certificate) {
            // Increment the download count
            $certificate->increment('download_count');
        } else {
            // Create a new certificate
            $certificate = self::create([
                'user_id' => $studentId,
                'course_id' => $courseId,
                'code' => self::generateCode(),
                'download_count' => 1,
            ]);
        }

        return $certificate;
    }
}
