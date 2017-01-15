<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $userRole = new \LaravelItalia\Domain\Role();
        $userRole->name = 'user';
        $userRole->save();
    }
}
