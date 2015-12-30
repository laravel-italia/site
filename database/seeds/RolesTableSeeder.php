<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $administratorRole = new \LaravelItalia\Entities\Role();
        $administratorRole->name = 'administrator';
        $administratorRole->save();

        $editorRole = new \LaravelItalia\Entities\Role();
        $editorRole->name = 'editor';
        $editorRole->save();

        $userRole = new \LaravelItalia\Entities\Role();
        $userRole->name = 'user';
        $userRole->save();
    }
}
