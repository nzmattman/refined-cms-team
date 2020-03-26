<?php

namespace RefinedDigital\Team\Commands;

use Illuminate\Console\Command;
use Validator;
use Artisan;
use DB;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refinedCMS:install-team';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the team files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->migrate();
        $this->seed();
        $this->publish();
        $this->info('Team has been successfully installed');
    }


    protected function migrate()
    {
        $this->output->writeln('<info>Migrating the database</info>');
        Artisan::call('migrate', [
            '--path' => 'vendor/refineddigital/cms-team/src/Database/Migrations',
            '--force' => 1,
        ]);
    }

    protected function seed()
    {
        $this->output->writeln('<info>Seeding the database</info>');
        Artisan::call('db:seed', [
            '--class' => '\\RefinedDigital\\Teams\\Database\\Seeds\\TeamDatabaseSeeder',
            '--force' => 1
        ]);
    }

    protected function publish()
    {
        Artisan::call('vendor:publish', [
            '--tag' => 'team',
        ]);

        // grab the team details template id
        $template = \DB::table('templates')
                        ->whereName('Team Details')
                        ->first();

        if (isset($template->id)) {
            // override the template id of the team details
            $configFile = config_path('team.php');
            $file = file_get_contents($configFile);
            $search = [ "'__ID__'" ];
            $replace = [ $template->id ];
            file_put_contents($configFile, str_replace($search, $replace, $file));
        }
    }

}
