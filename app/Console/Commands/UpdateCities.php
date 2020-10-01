<?php

namespace App\Console\Commands;

use App\CitiesStatus;
use App\Jobs\UpdateCitiesJob;
use Illuminate\Console\Command;

class UpdateCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $checkData = CitiesStatus::query()->first();
        dispatch(new UpdateCitiesJob($checkData));
    }
}
