<?php

namespace App\Console\Commands;

use App\Whitelist;
use Illuminate\Console\Command;

class WhitelistListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whitelist:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the currently whitelisted emails';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = Whitelist::all();

        if ($emails->isEmpty()) {
            $this->info('Whitelist is empty');
            return;
        }

        $this->info('Whitelisted emails:');
        foreach ($emails as $email) {
            $this->line($email);
        }
    }
}
