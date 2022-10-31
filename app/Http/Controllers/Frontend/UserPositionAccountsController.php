<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\StoreUserPositionAccountRequest;
use App\Models\User;
use App\Models\UserPositionAccount;
use App\Models\CbmMtFourAccount;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPositionAccountsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('user_position_account_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userPositionAccounts = UserPositionAccount::all();

        return view('frontend.userPositionAccounts.index', compact('userPositionAccounts'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_position_account_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.userPositionAccounts.create');
    }

    public function store(StoreUserPositionAccountRequest $request)
    {
        $userPositionAccount = UserPositionAccount::create($request->all());

        return redirect()->route('frontend.user-position-accounts.index');
    }

    public function accountData($id)
    {
        $url_user_id = $id;
        $id=base64_decode($id);
        $user = User::find($id);
        $mt_four_user = CbmMtFourAccount::where('email_address',$user->email)->get();
        return view('frontend.account',compact('mt_four_user','url_user_id'));
    }
}
