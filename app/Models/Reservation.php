<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Reservation extends Model
{
    use HasFactory;
    protected $table='reservations';

    public static function ensureStorage(): void
    {
        static $ready = false;
        if ($ready || !Schema::hasTable('reservations')) {
            return;
        }

        $existing = Schema::getColumnListing('reservations');
        $definitions = [
            'channel' => fn (Blueprint $table) => $table->string('channel')->nullable(),
            'arrival_date' => fn (Blueprint $table) => $table->date('arrival_date')->nullable(),
            'date_in' => fn (Blueprint $table) => $table->date('date_in')->nullable(),
            'date_out' => fn (Blueprint $table) => $table->date('date_out')->nullable(),
            'guests' => fn (Blueprint $table) => $table->integer('guests')->nullable(),
            'nights' => fn (Blueprint $table) => $table->integer('nights')->nullable(),
            'message' => fn (Blueprint $table) => $table->longText('message')->nullable(),
            'facility_id' => fn (Blueprint $table) => $table->unsignedBigInteger('facility_id')->nullable(),
        ];

        foreach ($definitions as $column => $define) {
            if (in_array($column, $existing, true)) {
                continue;
            }

            try {
                Schema::table('reservations', function (Blueprint $table) use ($define) {
                    $define($table);
                });
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        try {
            $status = DB::selectOne("SHOW COLUMNS FROM reservations WHERE Field = 'status'");
            if ($status && stripos((string) $status->Type, 'enum') !== false) {
                DB::statement("ALTER TABLE reservations MODIFY status VARCHAR(50) NULL DEFAULT 'Pending'");
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        $ready = true;
    }

    public static function storeBooking(array $attributes): self
    {
        self::ensureStorage();

        $columns = array_flip(Schema::getColumnListing('reservations'));
        $data = array_intersect_key($attributes, $columns);

        if (isset($columns['status'])) {
            $data['status'] = $attributes['status'] ?? 'Pending';
        }

        try {
            return static::create($data);
        } catch (QueryException $exception) {
            if (($data['status'] ?? null) !== 'pending') {
                $data['status'] = 'pending';

                return static::create($data);
            }

            throw $exception;
        }
    }

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
