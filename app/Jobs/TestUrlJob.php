<?php

namespace App\Jobs;

use App\Models\Result;
use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class TestUrlJob extends Job
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 6;

    /**
     * @var Url
     */
    public $url;

    /**
     * @var string
     */
    private $actionKey;

    /**
     * @var int
     */
    private $threshold;


    private $dacyTime;

    /**
     * Create a new job instance.
     *
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
        $this->actionKey = $url->link . '_' . $url->id;
        $this->dacyTime = config('urls.rateLimiter.decayTime');
        $this->threshold = config('urls.rateLimiter.threshold');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        for ($i = 0; $i<=$this->threshold; $i++) {
            if (RateLimiter::tooManyAttempts($this->actionKey, $this->threshold)) {
                $this->storeResult(Result::STATUS['broken'],'The number of attempts made exceeds the set threshold');
                break;
            }
            try {
                Http::timeout(5)->get($this->url->link);
                $this->storeResult(Result::STATUS['success'], 'ok');
                RateLimiter::clear($this->actionKey);
                break;
            } catch (\Exception $exception) {
                $jobId = optional($this->job)->getJobId();
                Log::error("job_id : $jobId & link : {$this->url->link}  {$exception->getMessage()}");
                RateLimiter::hit($this->actionKey, Carbon::now()->addMinutes($this->dacyTime));
            }
        }

    }

    /**
     * @param bool $status
     * @param string $message
     */
    protected function storeResult(bool $status, $message = '')
    {
        $this->url->updateResultStatus(true);
        $this->url->results()->create(['status' => $status, 'message' => $message]);
    }
}
