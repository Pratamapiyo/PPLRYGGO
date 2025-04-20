<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Since we see in 0001_01_01_000000_create_users_table.php that the 
        // points column already exists, we can make this migration a no-op
        // or you could delete this file
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed
    }
}