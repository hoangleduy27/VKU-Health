<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body_temperature',
        'co2',
        'heart_beat',
        'blood_pressure',
        'image'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
