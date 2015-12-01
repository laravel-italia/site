<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
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
