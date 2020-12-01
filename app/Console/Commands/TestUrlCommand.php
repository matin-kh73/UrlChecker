<?php

namespace App\Console\Commands;


use App\Jobs\TestUrlJob;
use App\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestUrlCommand extends Command
{
    protected $name = 'fetch:urls';

    protected $description = 'Fetch the untested links';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $urls = Url::query()->unTestedLinks()->get();
        foreach ($urls as $url) {
            dispatch(new TestUrlJob($url));
        }
    }
}
