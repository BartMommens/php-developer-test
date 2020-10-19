<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Http\Controllers\PictureController;
use Illuminate\Console\Command;

class FillPictureDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pictures:fill';

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
        $endDate = CarbonImmutable::today();
        $startDate = new Carbon($endDate->subDays(30));

        while($startDate <= $endDate){
            if($picture_controller->get_picture_from_nasa($startDate->format('Y-m-d'))){
                $this->info('Picture for date:'.$startDate->format('Y-m-d').' success');
            }else{
                $this->info('Picture for date:'.$startDate->format('Y-m-d').' failed');
            }
            $startDate->addDay(1);
        }

        $this->info('Done.');
    }

}
