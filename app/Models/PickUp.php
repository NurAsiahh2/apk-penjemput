<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    protected $table = 'pickups';

    protected $fillable = [
        'student_id', 
        'pickup_name',
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
