<?php
namespace Database\Seeders\Tables;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Command :
         * artisan seed:generate --mode=table --all-tables
         *
         */

        $dataTables = [
            [
                'alamat' => 'Jl. Mekar Sari No. 27',
                'avatar_url' => 'https://untitledui.com/images/avatars/sarah-page',
                'created_at' => '2026-06-22 12:54:04',
                'email' => 'owner@recehan.com',
                'email_verified_at' => NULL,
                'id' => 1,
                'is_active' => 1,
                'last_login_at' => '2026-06-23 20:29:13',
                'name' => 'The Owner',
                'no_hp' => 8123456789,
                'password' => '$2y$12$QmY3QLfKInoMGMLNddP5ne0s7L2uGMIX6cwczNzchzHYO0IKGqfM.',
                'remember_token' => NULL,
                'updated_at' => '2026-06-23 20:29:13',
            ],
            [
                'alamat' => 'Jl. Sukarno Hatta No.27',
                'avatar_url' => 'https://untitledui.com/images/avatars/sophia-perez',
                'created_at' => '2026-06-23 12:21:36',
                'email' => 'bendahara@recehan.com',
                'email_verified_at' => NULL,
                'id' => 2,
                'is_active' => 1,
                'last_login_at' => '2026-06-23 19:25:36',
                'name' => 'Bendahara',
                'no_hp' => 8987654321,
                'password' => '$2y$12$drUwSU2nW8QROS6OkFr7YOZUc7IrBaQaIWcBWh4.2ZEEuruj4xNWy',
                'remember_token' => NULL,
                'updated_at' => '2026-06-23 19:25:36',
            ]
        ];
        
        DB::table("users")->insert($dataTables);
    }
}