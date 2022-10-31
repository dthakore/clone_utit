<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expert;
use App\Models\ExpertIcon;
use App\Models\User;
use App\Models\UserAlert;
use App\Models\UserExpertRequest;
use App\Models\MtfourDailyBalance;
use Illuminate\Support\Facades\Storage;

class FollowExpertController extends Controller
{

    public function getAllExperts()
    {
        $experts = Expert::get();
        foreach($experts as $exp){
            $email = auth()->user()->email;
            $balance = MtfourDailyBalance::select('balance')
                ->where('agent',$exp->agent)
                ->where('email',$email)->orderByDesc('created_at')->get()->toArray();
            $dates = MtfourDailyBalance::select('created_at')
                ->where('agent',$exp->agent)
                ->where('email',$email)->orderByDesc('created_at')->get()->toArray();
            $expertIcon = ExpertIcon::with(['media'])->where('expert_id', $exp->id)->get();
            $icons = [];
            if(!$expertIcon->isEmpty()){
                foreach($expertIcon as $ei){
                    $image_file = "";
                    $media = 0;
                    if(isset($ei->media)){
                        $allMediaFiles = $ei->media;
                        foreach($allMediaFiles as $amf){
                            $imageArr = $amf->getAttributes();
                            $image_file = $imageArr['file_name'];
                            $media = $imageArr['id'];
                            $icons[] = [
                                "url" => Storage::url("$media/$image_file"),
                                "tooltip" => $ei->tooltip
                            ];
                        }
                    }
                }
            }

            $get_req = UserExpertRequest::where('expert_id', $exp->id)->where('user_id', auth()->user()->id)->first();
            // dd($get_req);
            if(isset($get_req)){
                $exp->disabled = true;
            }else{
                $exp->disabled = false;
            }
            $exp->icons = $icons;
            $exp->balance = $balance;
            $exp->dates = $dates;
            $nameParts = explode(' ', trim($exp->name));
            $firstName = array_shift($nameParts);
            $lastName = array_pop($nameParts);
            $exp->initals = (
                mb_substr($firstName,0,1) .
                mb_substr($lastName,0,1)
            );
        }
        return $experts;
    }

    public function index()
    {
        $experts = $this->getAllExperts();
        return view('frontend.followExpert.index', compact('experts'));
    }

    public function getUserRequest(Request $request)
    {

        $users = User::leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('role_user.role_id', 1)
            ->pluck('id');

        // dd($users);
        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');
        $expert_name = $request->input('expert_name');
        $expert_id = $request->input('expert_id');

        $userExpert = new UserExpertRequest();
        $userExpert->user_id = $user_id;
        $userExpert->expert_id = $expert_id;
        $userExpert->status = '0';
        $userExpert->save();

        // $user_name = auth()->user()->name;
        $userAlert = new UserAlert();
        $userAlert->alert_text = 'New follow expert request from '.$user_name;
        $userAlert->alert_link = url("/admin/user-expert-request");
        $userAlert->show_hide = 1;
        $userAlert->type = '2';
        $userAlert->save();
        $userAlert->users()->sync($users);
        return response()->json(['status'=> 1, 'success'=> 'Your request to Follow Expert - '.$expert_name. ' has been received.']);
    }
}
