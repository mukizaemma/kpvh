<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table='reservations';

    protected $fillable = [
        'names',
        'phone',
        'email',
        'channel',
        'arrival_date',
        'date_in',
        'date_out',
        'nights',
        'guests',
        'message',
        'status',
        'facility_id',
        'room_id',
    ];

    public function guestWhatsappLink(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->phone);
        if ($digits === '') {
            return null;
        }
        if (str_starts_with($digits, '0')) {
            $digits = '250'.substr($digits, 1);
        }

        return 'https://wa.me/'.$digits;
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
    public function facility(){
        return $this->belongsTo(Facility::class);
    }
}
