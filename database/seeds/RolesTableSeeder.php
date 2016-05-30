<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $administratorRole = new \LaravelItalia\Domain\Role();
        $administratorRole->name = 'administrator';
        $administratorRole->save();

        $editorRole = new \LaravelItalia\Domain\Role();
        $editorRole->name = 'editor';
        $editorRole->save();
    }
}
