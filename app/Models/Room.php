<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table='rooms';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'status',
        'user_id',
        'price',
        'amenity_id',
    ];

    /**
     * Prices are stored as strings. Always expose a float so number_format()
     * accepts values like "120", "$120", or "1,200.50".
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return self::normalizePrice($value) ?? 0.0;
            },
            set: function ($value) {
                $normalized = self::normalizePrice($value);

                return $normalized === null ? null : (string) $normalized;
            },
        );
    }

    private static function normalizePrice($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $normalized = preg_replace('/[^0-9.\-]/', '', (string) $value);

        return is_numeric($normalized) ? (float) $normalized : null;
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function images(){
        return $this->hasMany(Roomimage::class);
    }
}
