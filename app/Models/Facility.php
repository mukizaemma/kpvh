<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $table='facilities';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'status',
        'added_by',
    ];

    public function images(){
        return $this->hasMany(Facilityimage::class);
    }
}
