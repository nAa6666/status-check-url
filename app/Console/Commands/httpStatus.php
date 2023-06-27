<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class httpStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'http-status {link?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Status url';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        return $this->check();
    }

    public function check()
    {
        $client = new Client();
        $statusCode = null;

        if (collect($this->argument('link'))->count() > 0){
            foreach ($this->argument('link') as $link){
                try {
                    $statusCode = $client->get($link)->getStatusCode();
                    $this->info(
                        sprintf('[%s] - %s | %s', Carbon::now()->format('Y-m-d H:i:s'), $statusCode, $link)
                    );
                } catch (GuzzleException $e) {
                    $this->info(
                        sprintf('[%s] - %s | %s', Carbon::now()->format('Y-m-d H:i:s'), $e->getCode(), $link)
                    );
                }
            }
        }
    }
}
