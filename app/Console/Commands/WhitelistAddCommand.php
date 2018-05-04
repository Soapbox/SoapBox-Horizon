<?php

namespace App\Console\Commands;

use App\Whitelist;
use Illuminate\Console\Command;

class WhitelistAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whitelist:add {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an email to the whitelist';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        Whitelist::add($email);
    }
}
