<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventpage extends Model
{
    use HasFactory;
    protected $table = 'eventpages';

    protected $fillable = [
        'description',
        'details',
        'image',
    ];
    public function images(){
        return $this->hasMany(Eventimage::class);
    }
}
