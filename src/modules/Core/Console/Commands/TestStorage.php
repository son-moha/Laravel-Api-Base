<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Entities\Mails\Test;

class TestStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:test-connect-s3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Storage test';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Storage::disk('s3')->exists('demo.png')) {
            $this->info('connected');
            $url = storage_url('/demo.png');
            $this->info('link: ' . $url);
        } else {
            $this->info('not connected');
        }
    }
}
