<?php

namespace App\Console\Commands;

use App\Match;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MatchesClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matches:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purges any deleted matches are are older than 30 days';

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
        $matches = Match::onlyTrashed()->where('deleted_at', '<', Carbon::now()->subDay(28))
			->forceDelete();

        $this->info("$matches match purged");
    }
}
