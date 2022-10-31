<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expert;
use Illuminate\Http\Request;
use App\Models\UserExpertRequest;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class UserExpertRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UserExpertRequest::select('*', 'experts.name as exp_name', 'user_expert_requests.created_at as fr_created_at', 'user_expert_requests.id as fr_id', 'user_expert_requests.id as id')
                    ->leftJoin('experts', 'experts.id', '=', 'user_expert_requests.expert_id')
                    ->leftJoin('users', 'users.id', '=', 'user_expert_requests.user_id')
                    ->get();
            
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = '';
                $editGate = 'user_expert_edit';
                $deleteGate = '';
                $crudRoutePart = 'user-expert-request';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->fr_id;
            });
            $table->editColumn('name', function ($row) {
                return $row->first_name . ' '. $row->last_name;
            });
            $table->editColumn('expert_id', function ($row) {
                return $row->exp_name ;
            });

            $table->editColumn('status', function ($row) {
                return  UserExpertRequest::STATUS[$row->status] ;
            });

            $table->editColumn('created_at', function ($row) {
                return $row->fr_created_at ? $row->fr_created_at : '';

            });

            $table->rawColumns(['actions', 'placeholder']);
            
            return $table->make(true);
        }
        return view('admin.userExpertRequest.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        abort_if(Gate::denies('user_expert_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_expert =  UserExpertRequest::find($id);
        $user_name =  User::where('id',$user_expert->user_id)->first();
        $expert_name =  Expert::where('id',$user_expert->expert_id)->first();
        return view('admin.userExpertRequest.edit',compact('user_expert','user_name','expert_name'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        UserExpertRequest::where('id', $id)->update(
            [
                'status' => $request->status,
                
            ]);

        return redirect()->route('admin.user-expert-request.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
