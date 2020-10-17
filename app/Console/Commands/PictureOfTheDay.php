<?php

namespace App\Console\Commands;

use App\Http\Controllers\PictureController;
use Illuminate\Console\Command;

class PictureOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pictures:getpod';

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
     * @return int
     */
    public function handle()
    {
        $picture_controller = new PictureController();
        if($picture_controller->get_picture_of_the_day()){
            $this->info('Job done');
        }else{
            $this->info('Job failed?');
        }
    }
}
