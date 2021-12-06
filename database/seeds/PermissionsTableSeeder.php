<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editor_role = Role::where('slug','editor')->first();
        $reader_role = Role::where('slug', 'reader')->first();

        $createPodcasts = new Permission();
        $createPodcasts->slug = 'create-podasts';
        $createPodcasts->name = 'Create podasts';
        $createPodcasts->save();
        $createPodcasts->roles()->attach($editor_role);

        $readPodcasts = new Permission();
        $readPodcasts->slug = 'read-podasts';
        $readPodcasts->name = 'Read Podasts';
        $readPodcasts->save();
        $readPodcasts->roles()->attach($reader_role);
    }
}
