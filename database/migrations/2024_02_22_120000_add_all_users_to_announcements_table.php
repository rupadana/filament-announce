<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->boolean('all_users')
                ->default(false)
                ->after('users');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
           $table->dropColumn('all_users');
        });
    }
};
