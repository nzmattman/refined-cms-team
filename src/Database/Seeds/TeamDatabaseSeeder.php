<?php

namespace RefinedDigital\Team\Database\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TeamDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TeamTemplatesTableSeeder::class);
    }
}
