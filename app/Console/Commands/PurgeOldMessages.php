<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class PurgeOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purge-old-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes messages from the system to prevent it being overcumbersome, currently set to 3 months';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $cutOffDate = now()->subMonths(3);

        DB::table('messages')
            ->where('created_at', '<', $cutOffDate)
            ->delete();

        $this->info('Old messages purged successfully.');
    }
}
