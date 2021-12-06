<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Date;
use App\Admin;
use App\Role;
use App\Permission;

class AdminsTableSeeder extends Seeder
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
        $createPodcastsPermission = Permission::where('slug', 'create-podasts')->first();
        $readPodcastsPermission = Permission::where('slug', 'read-podasts')->first();

        $admins = [
            [
                'first_name' => 'Super',
                'last_name' => "Admin",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => $this->freshTimestamp(),
                'is_super' => true,
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp()
            ],
            [
                'first_name' => 'Editor',
                'last_name' => "Admin",
                'email' => 'editor@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => $this->freshTimestamp(),
                'is_super' => false,
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp()
            ],
            [
                'first_name' => 'Reader',
                'last_name' => "Admin",
                'email' => 'reader@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => $this->freshTimestamp(),
                'is_super' => false,
                'created_at' => $this->freshTimestamp(),
                'updated_at' => $this->freshTimestamp()
            ],
        ];
        foreach ($admins as $admin) {
            $admin = Admin::create($admin);
            switch ($admin->first_name) {
                case 'Super':
                    $admin->roles()->attach($editor_role);
                    $admin->permissions()->attach($createPodcastsPermission);
                    $admin->roles()->attach($reader_role);
                    $admin->permissions()->attach($readPodcastsPermission);
                    break;

                case 'Editor':
                    $admin->roles()->attach($editor_role);
                    $admin->permissions()->attach($createPodcastsPermission);
                    break;

                case 'Reader':
                    $admin->roles()->attach($reader_role);
                    $admin->permissions()->attach($readPodcastsPermission);
                    break;
                
                default:
                    break;
            }
        }
    }

    /**
     * Get a fresh timestamp for the model.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function freshTimestamp()
    {
        return Date::now();
    }
}
