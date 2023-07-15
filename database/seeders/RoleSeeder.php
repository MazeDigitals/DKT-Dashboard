<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'SuperAdmin',
            'slug' => 'superadmin',
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'Josh',
            'slug' => 'josh',
        ]);

        DB::table('roles')->insert([
            'id' => 4,
            'name' => 'DKT',
            'slug' => 'dkt',
        ]);

        DB::table('roles')->insert([
            'id' => 5,
            'name' => 'Dhanak',
            'slug' => 'dhanak',
        ]);

        DB::table('roles')->insert([
            'id' => 6,
            'name' => 'Heer',
            'slug' => 'heer',
        ]);

        DB::table('roles')->insert([
            'id' => 7,
            'name' => 'Sehatbaz',
            'slug' => 'sehatbaz',
        ]);

        DB::table('roles')->insert([
            'id' => 8,
            'name' => 'Sheroz',
            'slug' => 'sheroz',
        ]);
        
        DB::table('roles')->insert([
            'id' => 9,
            'name' => 'Okay',
            'slug' => 'okay',
        ]);

    }
}
