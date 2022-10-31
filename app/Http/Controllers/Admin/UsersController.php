<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Product;
use App\Models\Country;
use App\Models\Rank;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class UsersController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
//            $query = User::with(['sponsor', 'country'])->select(sprintf('%s.*', (new User())->table));

            if(($request->has('search')) && ($request->get('search')['value'] != null)){
                $query = User::with(['country'])
                    ->leftJoin('users as sponsor', 'users.sponsor_id', '=', 'sponsor.id')
                    ->select(sprintf('%s.*', (new User())->table),'sponsor.name as sponsor_name');
            }
            else{
                $query = User::with(['sponsor', 'country'])->select(sprintf('%s.*', (new User())->table));
            }

            $start = "";
            $end = "";
            if ($request->has('sponsor_id') && $request->get('sponsor_id') != null) {
                $sponsor = User::where("id", "like","%{$request->get('sponsor_id')}%")->first();
                if(isset($sponsor->id)){
                    $query->where('sponsor_id', $sponsor->id);
                }else{
                    $query->where('sponsor_id', "");
                }
            }

            if ($request->has('sponsor') && $request->get('sponsor') != null) {
                $name = explode(" ~ ", $request->get('sponsor'));
                if(isset($name[1])){
                    $query->where('sponsor_id', $name[1]);
                }else{
                    $query->where('sponsor_id', "");
                }
            }
            if ($request->has('user_id') && $request->get('user_id') != null) {
                $query->where("id", $request->get('user_id'));
            }
            if ($request->has('name') && $request->get('name') != null) {
                $name = explode(" ~ ", $request->get('name'));
                $query->where("name", "like","%{$name[0]}%");
            }
            if ($request->has('email') && $request->get('email') != null) {
                $query->where("email", "like","%{$request->get('email')}%");
            }
            if ($request->has('city') && $request->get('city') != null) {
                $query->where("city", "like","%{$request->get('city')}%");
            }
            if ($request->has('phone') && $request->get('phone') != null) {
                $query->where('phone', 'like', "%{$request->get('phone')}%");
            }
            if ($request->has('country') && $request->get('country') != null) {
                $query->where('country_id', $request->get('country'));
            }
            if ($request->has('rank') && $request->get('rank') != null) {
                $query->where('rank_id', $request->get('rank'));
            }
            if ($request->has('product') && $request->get('product') != null) {
                $query->where("product_id", $request->get('product'));
            }
            if ($request->has('verified') && $request->get('verified') != null) {
                $query->where('verified', $request->get('verified'));
            }
            if ($request->has('role') && $request->get('role') != null) {
                $users = \DB::table('role_user')->select('user_id')->where('role_id', $request->get('role'))->pluck('user_id')->toArray();
                $query->whereIn('id', $users);
            }
            if($request->get('start_date') != null){
                $start = date('Y-m-d 00:00:00',strtotime($request->get('start_date')));
            }
            if($request->get('end_date') != null){
                $end = date('Y-m-d 23:59:59',strtotime($request->get('end_date')));
            }
            if ($start != '' && $end != '') {
                $query->whereBetween('created_at', [$start, $end]);
            } else if ($start != '') {
                $query->where("created_at", "like", "%{$start}%");
            }
//            $query->orderBy('id', 'DESC');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $treeGate = true;
                $crudRoutePart = 'users';
                $autoLogin = true;
                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'treeGate',
                'deleteGate',
                'crudRoutePart',
                'autoLogin',
                'row'
            ));
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->addColumn('sponsor_name', function ($row) {
                return $row->sponsor ? $row->sponsor->name : '';
            });

//            $table->editColumn('city', function ($row) {
//                return $row->city ? $row->city : '';
//            });
            $table->addColumn('country_name', function ($row) {
                return $row->country ? $row->country->name : '';
            });

//            $table->addColumn('rank_name', function ($row) {
//                return $row->rank ? $row->rank->name : '';
//            });

//            $table->rawColumns(['actions', 'placeholder', 'sponsor', 'country', 'rank']);
            $table->rawColumns(['actions', 'placeholder', 'sponsor', 'country']);

            return $table->make(true);
        }

        $users     = User::get();
        $countries = Country::get();
        $roles     = Role::get();
        $ranks     = Rank::get();
        $products  = Product::get();

        return view('admin.users.index', compact('countries', 'roles', 'ranks', 'products','users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sponsors = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bus_address_countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $roles = Role::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ranks = Rank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('sponsors', 'countries', 'bus_address_countries', 'roles', 'ranks', 'products'));
    }

    public function store(StoreUserRequest $request)
    {
        $inputs = $request->all();
        $inputs ['name'] = $inputs['first_name'].' '.$inputs['last_name'];
        session(['audit_log' => "(Admin)User ".auth()->id()." created new user", 'audit_log_category' => "Register"]);
        $user = User::create($inputs);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sponsors = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bus_address_countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $roles = Role::pluck('title', 'id');

        $ranks = Rank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('sponsor', 'country', 'bus_address_country', 'roles', 'rank');

        return view('admin.users.edit', compact('sponsors', 'countries', 'bus_address_countries', 'roles', 'ranks', 'user', 'products'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $inputs = $request->all();
        $inputs ['name'] = $inputs['first_name'].' '.$inputs['last_name'];
        session(['audit_log' => "(Admin)User ".auth()->id()." updated user {$user->id} details", 'audit_log_category' => "Profile Update"]);
        $user->update($inputs);
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('sponsor', 'country', 'bus_address_country', 'roles', 'rank', 'sponsorUsers', 'userAllwallettransactions', 'userOrders', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        session(['audit_log' => "(Admin)User ".auth()->id()." deleted user {$user->id} account", 'audit_log_category' => "Profile Update"]);

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    function childData($id,$name){
        $childs =  User::where(['sponsor_id' => $id])->get();
        $finaldata = [];
        if(count($childs) > 0){
            foreach ($childs as $child){
                if($child->id != $child->sponsor_id){
                    $role = "";
                    if(isset($child->roles)){
                        foreach ($child->roles as $roles){
                            $role = " : " .$roles->title;
                        }
                    }
                    $data['name'] = $child->name . $role;
                    $data['parent'] = $name;
                    $data['children'] = $this->childData($child->id,$child->name);
                    $finaldata[] = $data;
                }
            }
        }
        return $finaldata;
    }

    public function treeView(){
        $parents = User::whereNull(['sponsor_id'])->get();
        $finaldata = [];
        if(count($parents) > 0){
            foreach ($parents as $parent){
                $data['name'] = $parent->name;
                $data['parent'] = null;
                $data['children'] = $this->childData($parent->id,$parent->name);
                $finaldata[] = $data;
            }

        }
        $result = json_encode($finaldata);
        return view('admin.users.tree-view', compact('result'));
    }

    public function tree($id){
        $parents = User::where(['id' => $id])->get();
        $finaldata = [];
        if(count($parents) > 0){
            foreach ($parents as $parent){
                $data['name'] = $parent->name;
                $data['parent'] = $parent->id;
                $data['children'] = $this->childData($parent->id,$parent->name);
                $finaldata[] = $data;
            }

        }
        $result = json_encode($finaldata);
        return view('admin.users.tree-view', compact('result'));
    }
    public function autoLogin($id)
    {
        $user = User::find($id);
        AuditLog::insertLog("(Admin)User ".auth()->id()." logged in to user {$id} account", "Login/Logout", $user, "created");
        Auth::user()->setImpersonating($user->id);

        return redirect()->route('frontend.home');
    }

    public function stopAutoLogin()
    {
            Auth::user()->stopImpersonating();

            flash()->success('Welcome back!');

            return redirect()->route('frontend.home');
    }
}
