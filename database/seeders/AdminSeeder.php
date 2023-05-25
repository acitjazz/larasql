<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {

            $user = Admin::firstOrCreate(
                [
                    'email' =>   'super@admin.test',
                ]
            );
            $user->name = 'Super Admin';
            $user->password = Hash::make('1q2w3e++2023');
            $user->email_verified_at = Carbon::now();
            $user->update();

            $this->command->info('Creating...' . $user->name);



            $this->command->info('Creating...' . $user->name);

            cache()->flush();
        } catch (\Exception $e) {
            $this->command->info($e->getMessage());
        }
    }
}
