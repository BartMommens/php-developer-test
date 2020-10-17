<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function index(Request $request){
        $today = Carbon::today()->format('Y-m-d');
        $pod = Picture::where('created_at', $today)->first();

        if(empty($pod)){
            $pod = Picture::orderBy('created_at', 'desc')->first();
        }


        $pictures = Picture::query()
            ->orderBy('created_at', 'desc')
            ->where('created_at', '!=' , $today)
            ->paginate(9)
            ->onEachSide(1);
        $likes = [];

        $like_controller = new LikeController();

        $user = $like_controller->hash_ip($request->ip());
        //Optimization required ... should be more lean ... saving some time to complete test goal
        foreach ($pictures as $picture){
            $likes[$picture->id]['count'] = $picture->likes()->count();
            foreach ($picture->likes as $like){
                if($like->liked_by === $user){
                    $likes[$picture->id]['user_liked'] = true;
                    break 1;
                }
            }
        }

        return view('pages/index', compact(['pod','pictures','likes','today']));
    }

    public function view_detail(Request $request, $id){
        $item = Picture::findOrFail($id);
        return view('pages/detail', compact(['item']));
    }


    //Controlled by cronjob
    public function get_picture_of_the_day(){
        $today = CarbonImmutable::today();
        if(empty($this->find_picture_for_date($today))){
         return $this->get_picture_from_nasa($today->format('Y-m-d'));
        }
        return true;
    }

    public function find_picture_for_date($date)
    {
           return Picture::where('created_at' , $date )->first();
    }

    public function get_picture_from_nasa($date){
        $client = new Client();
        try{
            $res = $client->get('https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY&date='.$date);
            $body =  json_decode($res->getBody());

            if(empty($body->url) || empty($body->date) || empty($body->media_type)){
                return false;
            }
            $data =
                [
                    'title' => (!empty($body->title))? $body->title : 'No title' ,
                    'copyright' => (!empty($body->copyright))? $body->copyright : '' ,
                    'explanation' => (!empty($body->explanation))? $body->explanation : '...',
                    'url' => $body->url,
                    'hdurl' => (!empty($body->hdurl))? $body->hdurl : $body->url,
                    'media_type' => $body->media_type,
                    'created_at' => $body->date
                ];

            return $this->store_picture($data);
        }catch (ClientException $exception){
            return false;
        }
    }

    protected function store_picture($picture_data){
        return Picture::create($picture_data);
    }
}
