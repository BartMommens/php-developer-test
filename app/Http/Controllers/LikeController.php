<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function like_picture(Request $request){
        $picture_id = $request->picture_id;
        $user_ip = $request->ip();
        $state = true;
        if(empty($this->check_like_for_ip($picture_id, $user_ip))){
            $state = $this->register_like($picture_id, $user_ip);
        }



        return response()->json([
            'state' => ($state)? 'success' : 'failed',
            'likes' => $this->get_like_count($picture_id)
        ]);
    }

    public function user_liked(Request $request, $picture_id){
        $user_ip = $request->ip();
        if(empty($this->check_like_for_ip($picture_id, $user_ip))){
            return false;
        }
        return true;
    }

    protected function get_like_count($picture_id){
        return Like::where('picture_id',$picture_id)->count();
    }

    protected function check_like_for_ip($picture_id, $ip){
        $user = $this->hash_ip($ip);
        return Like::where('picture_id',$picture_id)->where('liked_by',$user)->first();
    }

    protected function register_like($picture_id, $ip){
        $user = $this->hash_ip($ip);
        return Like::create([
            'picture_id' => $picture_id,
            'liked_by' => $user
        ]);
    }

    public function hash_ip($ip){
        return hash('sha256', $ip);
    }
}
