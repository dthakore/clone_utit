<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expert;
use App\Models\ExpertIcon;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Yajra\DataTables\Facades\DataTables;

class FollowExpertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Expert::query()->select(sprintf('%s.*', (new Expert())->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'expert_show';
                $editGate = 'expert_edit';
                $deleteGate = 'expert_delete';
                $crudRoutePart = 'experts';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }
        return view('admin.followExpert.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.followExpert.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $res = Expert::create($inputs);
        $tooltips = $request->input('tooltip');
        $photos = $request->input('photo');
        // dd($photos);
        if(isset($photos)){
            foreach ($photos as  $key=>$ph)
            {
                $expertIc = new ExpertIcon();
                if(isset($tooltips[$key])){
                    $expertIc->tooltip = $tooltips[$key];
                }else{
                    $expertIc->tooltip = '';

                }
                $expertIc->expert_id = $res->id;
                $expertIc->addMedia(storage_path('tmp/uploads/' . basename($ph)))->toMediaCollection('expertIcons');
                $expertIc->save();
            }
        }


        return redirect()->route('admin.experts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('expert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expert = Expert::find($id);
        $expert_icon = ExpertIcon::where('id',$id)->first();
        return view('admin.followExpert.show', compact('expert','expert_icon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('expert_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $expert = Expert::find($id);
        $expert_icon = ExpertIcon::where('expert_id',$id)->get();

        return view('admin.followExpert.edit', compact('expert','expert_icon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $expert = Expert::find($id);
        $expert->name = $request->name;
        $expert->account = $request->account;
        $expert->type = $request->type;
        $expert->agent = $request->agent;
        $expert->agent_name = $request->agent_name;
        $expert->group = $request->group;
        $expert->broker = $request->broker;
        $expert->asset_manager = $request->asset_manager;
        $expert->minimum_deposit = $request->minimum_deposit;
        $expert->asset_type = $request->asset_type;
        $expert->setting = $request->setting;
        $expert->total_investors = $request->total_investors;
        $expert->aum = $request->aum;
        $expert->is_forex = $request->is_forex;
        $expert->is_verified = $request->is_verified;
        $expert->is_manual_trader = $request->is_manual_trader;
        $expert->currency = $request->currency;
        $expert->performance_fee = $request->performance_fee;
        $expert->abs_gain = $request->abs_gain;
        $expert->max_dd = $request->max_dd;
        $expert->save();

        $tooltips = $request->input('tooltip');
        $photos = $request->input('photo');
        if(isset($photos)){
            ExpertIcon::where('expert_id', $id)->delete();
            foreach ($photos as  $key=>$ph)
            {
                $expertIc = new ExpertIcon();
                if(isset($tooltips[$key])){
                    $expertIc->tooltip = $tooltips[$key];
                }else{
                    $expertIc->tooltip = '';
                }
                $expertIc->expert_id = $id;
                $expertIc->addMedia(storage_path('tmp/uploads/' . basename($ph)))->toMediaCollection('expertIcons');
                $expertIc->save();
            }
        }

        return redirect()->route('admin.experts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('expert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expert = Expert::findOrFail($id);
        $expert->delete();
        return back();
    }
}
