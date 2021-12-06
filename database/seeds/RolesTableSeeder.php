<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editor_role = new Role();
        $editor_role->slug = 'editor';
        $editor_role->name = 'Podcasts editor';
        $editor_role->save();

        $reader_role = new Role();
        $reader_role->slug = 'reader';
        $reader_role->name = 'Podcasts reader';
        $reader_role->save();
    }
}
