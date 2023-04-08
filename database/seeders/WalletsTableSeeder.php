<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;

class WalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->balance = random_int(0, 10000) / 100;
            $wallet->save();
        });
    }
}
