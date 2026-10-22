<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('no_hp')->nullable()->after('email');

            $table->text('alamat')->nullable();

            $table->string('foto')->nullable();
            
            $table->string('avatar_url')->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamp('last_login_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'no_hp',
                'alamat',
                'foto',
                'avatar_url',
                'is_active',
                'last_login_at'
            ]);
        });
    }
};