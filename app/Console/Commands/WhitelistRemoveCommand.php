<?php

namespace App\Console\Commands;

use App\Whitelist;
use Illuminate\Console\Command;

class WhitelistRemoveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whitelist:remove {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an email from the whitelist';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        Whitelist::remove($email);
    }
}
