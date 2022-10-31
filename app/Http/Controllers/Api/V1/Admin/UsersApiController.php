<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['sponsor', 'country', 'bus_address_country', 'roles', 'rank'])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['sponsor', 'country', 'bus_address_country', 'roles', 'rank']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function autocompleteEmail(Request $request)
    {
        $email = $request->get('email');
        $filterResult = User::select('email')->where('email', 'LIKE', '%'. $email. '%')->get();
        return response()->json($filterResult);
    }
    public function autocompleteId(Request $request)
    {
        $id = $request->get('id');
        $filterResult = User::select('id as name')->where('id', 'LIKE', '%'. $id. '%')->get();
        return response()->json($filterResult);
    }
    public function autocompleteName(Request $request)
    {
        $name = $request->get('name');
        $filterResult = User::select([DB::raw("CONCAT(name, ' ~ ', id) as name")])->where('name', 'LIKE', '%'. $name. '%')->orWhere('id', 'LIKE', '%'. $name. '%')->get();
        return response()->json($filterResult);
    }
    public function getUser(Request $request)
    {
        try {
            $date = date('Y-m-d H:i:s');
            $response = [];
            $user = User::where('email', $request->email)->first();

            if (\DateTime::createFromFormat('Y-m-d H:i:s', $user->created_at) !== false) {
                $date = date('Y-m-d H:i:s', strtotime($user->created_at));
            }
            $temp['registered_at'] = $date;
            $temp['sponsor_id'] = isset($user->sponsor_id) ? $user->sponsor_id : 0;
            $temp['allow_notification_mail'] = $user->notification_mail ?? 0;
            $temp['allow_marketing_mail'] = $user->marketting_mail ?? 0;
            $temp['created_at'] = $date;
            
            $response['status'] = 1;
            $response['data'] = $temp;
        } catch (Exception $e){
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function sioAutoLogout(Request $request){
        try {
            if(isset($request->token)){
                $user = User::where(['api_token' => $request->token])->first();
                if(isset($user->id)) {
                    $user->api_token = null;
                    $user->update();

                    session()->flush();
                    Auth::logout();

                    $response['status'] = 1;
                    $response['message'] = 'Token invalidated successfully.';
                }else{
                    $response['status'] = 0;
                    $response['message'] = 'User not found';
                }
            } else {
                $response['status'] = 0;
                $response['message'] = 'Token not provided.';
            }
        } catch (Exception $e){
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
}
