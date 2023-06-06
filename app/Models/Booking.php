<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = [
        'lapangan_id',
        'time_from',
        'time_to',
        'user_id',
        'status',
        'bukti',

    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }
}
