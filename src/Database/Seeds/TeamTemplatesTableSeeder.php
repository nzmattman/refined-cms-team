<?php

namespace RefinedDigital\Team\Database\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class TeamTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'name'      => 'Team',
                'source'    => 'team',
                'active'    => 1,
            ],
            [
                'name'      => 'Team Details',
                'source'    => 'team-details',
                'active'    => 0,
            ],
        ];

        foreach($templates as $pos => $u) {
            $args = [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'position' => $pos,
            ];
            $data = array_merge($args, $u);
            DB::table('templates')->insert($data);
        }
    }
}
