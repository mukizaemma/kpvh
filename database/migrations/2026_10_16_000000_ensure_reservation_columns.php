<?php

use App\Models\Reservation;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Reservation::ensureStorage();
    }

    public function down(): void
    {
        //
    }
};
