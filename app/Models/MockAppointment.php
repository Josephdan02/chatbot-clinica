<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MockAppointment extends Model
{
    protected $table = 'mock_appointments';

    protected $fillable = [
        'user_identifier',
        'service',
        'date',
        'time',
        'status',
    ];
}
