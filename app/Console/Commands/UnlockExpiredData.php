<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TableAvailability;
use Carbon\Carbon;

class UnlockExpiredData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unlock-expired-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unlock Expired Data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = Carbon::now()->subMinutes(3);
        
        TableAvailability::where('created_at', '<=', $threshold)->where('state', 'locked')->update(['state' => 'unlocked']);;

        $this->info('Expired data unlock successfully.');
    }
}
