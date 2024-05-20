<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use App\Models\Courses;
use App\Models\Fields;
use App\Models\Introvideos;
use App\Models\Managers;
use App\Models\Podcasts;
use App\Models\Roadmaps;
use App\Models\socials;
use App\Models\Storys;
use App\Models\SubField;
use App\Models\Subseason;



use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Melipayamak\MelipayamakApi;

class ApiController extends Controller
{
    public function Profile(Request $request){
        $user = User::findOrFail($request->user_id);
        return response()->json([
            "avatar" => "https://amozeshgam.com/public/avatar/$user->avatar",
        ]);
    }
    public function login(Request $request){
        $user = User::where("phone", $request->phone)->get();
        $account = false;
        $verify_code = random_int(100000, 999999);

        if(isset($user[0])){
            $account = true;
            $user[0]->update([
                "code" => $verify_code
            ]);
        }else if($account == false){
            User::create([
                "code" => $verify_code,
                "phone" => $request->phone
            ]);
        }

        $username = '09059214470';
        $password = 'AF#M5';
        $api = new MelipayamakApi($username, $password);
        $sms = $api->sms('soap');
        $to = $request->phone;
        $text = array($verify_code);
        $bodyId = 207885;
        $response = $sms->sendByBaseNumber($text, $to, $bodyId);
        $json = json_decode($response);

        if($json > 0){
            return response()->json("OK");
        }else{
            return abort(500);
        }
    }

    public function check_code(Request $request){
        $user = User::where("phone", $request->phone)->get();
        $hash_login = Hash::make($request->phone);
        $account = false;

        if(isset($user[0])){
            $account = true;
            $user[0]->update([
                "hash_login" => $hash_login
            ]);
        }else{
            User::create([
                "phone" => $request->phone,
                "hash_login" => $hash_login,
            ]);
        }

        if($request->code == $user[0]->code){
            $user[0]->update([
                "code" => null
            ]);
            return response()->json([
                "account" => $account,
                "username" => $user[0]->username == null ? "" : $user[0]->username,
                "hash_login" => $user[0]->hash_login
            ]);
        }else{
            return abort(500);
        }
    }

    public function Home(Request $request){
        $storys = Storys::all()->map(function($story){
            return [
                "id"=>$story->id,
                "title"=>$story->title,
                "media" => "https://amozeshgam.com/public/Storys/$story->media"
            ];
        });
        $fields = Fields::all()->map(function($feild){
            return [
                "id"=>$feild->id,
                "title" => $feild->title,
                "image" => "https://amozeshgam.com/public/Fields/$feild->image",
            ];
        });
        $courses = Courses::all()->map(function($course){
            return [
                "id"=>$course->id,
                "title" => $course->title,
                "time" => $course->time,
                "teacher" => $course->teacher,
                "status" => $course->status == "پرطرفدار" ? 1 : 2,
                "image" => "https://amozeshgam.com/public/Courses/$course->image",
            ];
        });
        $banners = Banners::all()->map(function($banner){
            return [
                "id"=>$banner->id,
                "link"=>$banner->link,
                "image" => "https://amozeshgam.com/public/Banners/$banner->image"
            ];
        });
        $podcasts = Podcasts::all()->map(function($podcast){
            return [
                "id"=>$podcast->id,
                "image" => "https://amozeshgam.com/public/Podcasts/images/$podcast->image",
                "title" => $podcast->title,
                "speaker" => $podcast->speaker
            ];
        });
        $socials = socials::all()->map(function($social){
            return [
                "image" => "https://amozeshgam.com/public/Socials/$social->image",
                "link" => $social->link
            ];
        });
        $managers = Managers::all()->map(function($manager){
            return [
                "image" => "https://amozeshgam.com/public/Managers/$manager->image",
            ];
        });
        $roadmaps = Roadmaps::all()->map(function($roadmap){
            return [
                "id"=> $roadmap->id,
                "title"=> $roadmap->title,
                "image"=> "https://amozeshgam.com/public/Roadmap/$roadmap->image",
            ];
        });

        return response()->json([
            "Story"=>$storys,
            "Fields"=>$fields,
            "Courses"=>$courses,
            "Banners"=>$banners[0],
            "Podcasts"=>$podcasts,
            "Socials"=>$socials,
            "Managers"=>$managers[0],
            "Roadmap"=> $roadmaps
        ]);
    }

    public function comments(Request $request){
        $course = Courses::findOrFail($request->course_id);
        $comment = $course->comments;
        $result = $comment->map(function($item){
            return [
                "name"=>$item->user->name,
                "comment"=>$item->comment,
                "like"=>$item->like,
            ];
        });

        return response()->json([
            "comments"=>$result
        ]);
    }

    public function UploadAvatar(Request $request){
        $request->avatar->move(public_path('avatar'), $request->avatar->getClientOriginalName());
        $user = User::findOrFail($request->user_id);

        $user->update([
            "avatar" => $request->avatar->getClientOriginalName()
        ]);

        return response()->json([
            "message" => "Avatar Uploaded"
        ]);
    }

    public function GetCourse(Request $request){
        $course = Courses::findOrFail($request->course_id);
        $seasons = collect($course->seasons);
        $comments = collect($course->comments);
        $season = $seasons->map(function($item){
            $subseasons = collect($item->subseasons);
            $subseason = $subseasons->map(function($sub){
                return [
                    "title"=>$sub->title,
                    "time"=>$sub->time,
                ];
            });
            return [
                "title"=>$item->title,
                "sub"=> $subseason
            ];
        });
        $comment = $comments->map(function($item){
            $avatar = $item->user->avatar;
            return [
                "avatar" => "https://amozeshgam.com/public/avatar/$avatar",
                "name" => $item->user->name,
                "comment" => $item->comment
            ];
        });

        return response()->json([
            "course"=>[
                "image" => "https://amozeshgam.com/public/Courses/$course->image",
                "title" => $course->title,
                "description" => $course->description,
                "time" => $course->time,
                "teacher" => $course->teacher,
                "rate" => $course->rate,
            ],
            "seasons"=> $season,
            "comments"=>$comment
        ]);
    }

    public function GetField(Request $request){
        $field = Fields::findOrFail($request->field_id);
        $intro = Introvideos::where("model_type",class_basename($field)."_".strval($field->id))->get();
        $videos = collect($field->FieldVideos);

        $intro_video = collect($intro)->map(function($item){
            return [
                "video"=> "https://amozeshgam.com/public/intro/$item->video"
            ];
        });

        $subFields = collect($field->SubFields)->map(function($item){
            return [
                "id"=>$item->id,
                "title"=>$item->title,
                "image"=> "https://amozeshgam.ir/public/subfield_image/$item->image"
            ];
        });

        $field_videos = $videos->map(function($item){
            return [
                "video" => "https://amozeshgam.ir/public/field_videos/$item->video"
            ];
        });

        return response()->json([
            "intro" => $intro_video[0],
            "subfields" => $subFields,
            "videos" => $field_videos
        ]);
    }

    public function GetSubfield(Request $request){
        $sub_field = SubField::findOrFail($request->id);
        $intro = Introvideos::where("model_type",class_basename($sub_field)."_".strval($sub_field->id))->get();
        $sub_field_video = $sub_field->SubFieldVideo;

        $videos = collect($sub_field_video)->map(function($item){
            return [
                "video" => "https://amozeshgam.com/public/sub_field_video/$item->video"
            ];
        });
        $intro = collect($intro)->map(function($item){
            return [
                "video" => "https://amozeshgam.com/public/intro/$item->video"
            ];
        });

        return response()->json([
            "videos" => $videos,
            "intro" => $intro[0],
            "sub_field" => [
                "description" => $sub_field->description,
                "price" => $sub_field->price,
                "time" => $sub_field->time,
                "title" => $sub_field->title,
                "image" => "https://amozeshgam.com/public/subfield_image/$sub_field->image"
            ],
        ]);
    }

    public function AllCourse(Request $request){
        $courses = Courses::all();

        $AllCourses = $courses->map(function($course){
            return [
                "image" => "https://amozeshgam.com/public/Courses/$course->image",
                "title" => $course->title,
                "time" => $course->time,
                "teacher" => $course->teacher,
            ];
        });

        return response()->json([
            "courses"=>$AllCourses
        ]);
    }

    public function AllPodcasts(){
        $podcasts = Podcasts::all();

        $AllPodcast = $podcasts->map(function($podcast){
            return [
                "image" => "https://amozeshgam.com/public/Podcasts/images/$podcast->image",
                "title" => $podcast->title,
                "speaker" => $podcast->speaker,
            ];
        });

        return response()->json([
            "podcasts"=>$AllPodcast
        ]);
    }
}
