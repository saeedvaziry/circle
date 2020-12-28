<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreditLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit-limit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Credit limit';

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
     * @return void
     */
    public function handle()
    {
        $limit = get_limit();
        if ($limit->available_after <= 0) {
            get_limit()->update([
                'available' => 50,
                'last_credited' => now()
            ]);
        }
    }
}
