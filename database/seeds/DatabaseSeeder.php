<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(UserSeeder::class);
        \DB::table('users')->insert([
            'master' => 1,
            'name' => 'master',
            'email' => 'master@erp.com',
            'password' => bcrypt('secret')
        ]);

        \DB::table('users')->insert([
            'master' => 1,
            'name' => 'pmu',
            'email' => 'pmu@ord.com',
            'password' => bcrypt('secret')
        ]);

        $roles = [ 
            ['role' => 'Team Sub Head'],
            ['role' => 'User'],
            ['role' => 'Sub User'],
            ['role' => 'Partner 1'],
            ['role' => 'Partner 2'],
            ['role' => 'Client'],
        ];
        \DB::table('roles')->insert($roles);

        $statuses = [ 
            ['status' => 'Initiated','keyword' => 'Initiate'],
            ['status' => 'Approved','keyword' => 'Approve'],
            ['status' => 'Rejected','keyword' => 'Reject'],
            ['status' => 'On Hold','keyword' => 'On Hold'],
            ['status' => 'Work in Progess','keyword' => 'Work in Progess'],
            ['status' => 'Completed','keyword' => 'Complete'],
            ['status' => 'Pending','keyword' => 'Pending'],
            ['status' => 'pmu','keyword' => 'shared with PMU'],
            ['status' => 'client','keyword' => 'shared with Client'],
        ];
        \DB::table('statuses')->insert($statuses);

        
        $departments = [ 
            ['department' => 'Creative'],
            ['department' => 'Media'],
            ['department' => 'Digital'],
            ['department' => 'Social'],
            ['department' => 'BTL/Surveys']
        ];
        \DB::table('departments')->insert($departments);

        $districts = [ 
            ['district' => 'Badin'],
            ['district' => 'Sujawal'],
            ['district' => 'Tharparkar'],
            ['district' => 'UmerKot'],
            ['district' => 'Sanghar'],
            ['district' => 'Jacobabad'],
            ['district' => 'Kashmore'],
            ['district' => 'Ghotki'],
            ['district' => 'KambarShahdadkot'],
            ['district' => 'Khairpur']
        ];
        \DB::table('districts')->insert($districts);
    }
}
