<?php

namespace App\Console\Commands;

use Spatie\Ssh\Ssh;
use Illuminate\Console\Command;

class build extends Command
{
    protected $signature = 'build';

    protected $description = 'Run the build command on the remote server';

    protected $server = 'gukm1051.siteground.biz';
    protected $account = 'u1119-ahcvzbcli3ee';
    protected $port = 18765;
    protected $path = '~/www/marks364.sg-host.com';

    public function handle()
    {
        $this->comment('starting build on remote server');
        $this->warn('---------------------------------------------------');

        $process = Ssh::create($this->account, $this->server, $this->port)
        ->onOutput(function($type, $line){
            $this->line($line);
        })
        ->execute([
            'cd ' . $this->path,
            './build.sh'
        ]);

        $this->warn('---------------------------------------------------');

        if($process->isSuccessful()) {
            $this->comment('Successfully Finished Deployment');
            $this->newline();
            return Command::SUCCESS;
        } else {
            $this->error('Deployment failed');
            $this->newline();
            return Command::FAILURE;
        }
        
    }
}
