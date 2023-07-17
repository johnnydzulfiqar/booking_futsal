<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = [
        'lapangan_id',
        'time_from',
        'time_to',
        'jam',
        'total_harga',
        'user_id',
        'status',
        'bukti',
        'pembayaraan',
        'complete'

    ];
    public function getFotoBarangAttribute()
    {
        $bukti = $this->attributes['bukti'];
        if (empty($bukti)) return 'https://via.placeholder.com/100?text=Produk';
        else return Storage::url('img/' . $bukti);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class, 'lapangan_id');
    }
}
