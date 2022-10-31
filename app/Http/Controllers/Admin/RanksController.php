<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRankRequest;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Models\Rank;
use App\Models\RankRule;
use App\Models\User;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RanksController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('rank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Rank::query()->select(sprintf('%s.*', (new Rank())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'rank_show';
                $editGate = 'rank_edit';
                $deleteGate = 'rank_delete';
                $crudRoutePart = 'ranks';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('abbreviation', function ($row) {
                return $row->abbreviation ? $row->abbreviation : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.ranks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('rank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ranks.create');
    }

    public function store(StoreRankRequest $request)
    {
        $rank = Rank::create($request->all());

        if ($request->input('icon', false)) {
            $rank->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $rank->id]);
        }

        return redirect()->route('admin.settings.ranks');
    }

    public function edit(Rank $rank)
    {
        abort_if(Gate::denies('rank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ranks.edit', compact('rank'));
    }

    public function update(UpdateRankRequest $request, Rank $rank)
    {
        $rank->update($request->all());

        if ($request->input('icon', false)) {
            if (!$rank->icon || $request->input('icon') !== $rank->icon->file_name) {
                if ($rank->icon) {
                    $rank->icon->delete();
                }
                $rank->addMedia(storage_path('tmp/uploads/' . basename($request->input('icon'))))->toMediaCollection('icon');
            }
        } elseif ($rank->icon) {
            $rank->icon->delete();
        }

        return redirect()->route('admin.settings.ranks');
    }

    public function show(Rank $rank)
    {
        abort_if(Gate::denies('rank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ranks.show', compact('rank'));
    }

    public function destroy(Rank $rank)
    {
        abort_if(Gate::denies('rank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rank->delete();

        return back();
    }

    public function massDestroy(MassDestroyRankRequest $request)
    {
        Rank::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('rank_create') && Gate::denies('rank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Rank();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    /**
     * Compute Rank
     * @return array
     * */
    public function computeRank()
    {
        $newRank = $oldRank = $rankUser = $ranks = array();
        $users = User::all();
        foreach ($users as $user) {
            for ($i=11; $i > 0 ; $i--) {
                if($this->getCheckRanks($i ,$user->id)){
                    $setrank = User::find($user->id);
                    $setrank->rank_id = $i;
                    if ($setrank->save()){
                        $rankUser[] = $user->id;
                        $newRank[] = $i;
                        $oldRank[] = $user->rank_id;
                    }else{
                        echo $user->id." ";
                        print_r("Some error");
                        echo "<br>";
                    }
                    break;
                }
            }
        }
        echo json_encode([
            'users' => count($rankUser),
            'newrank' => $newRank,
            'oldrank' => $oldRank,
        ]);
    }

    /**
     * Check Rank
     * @return array
     * */
    protected function getCheckRanks($rankId, $userId){

        $totalSpent = $childCount = 1;
        $amount = $child = '';
        $NoOfChild = User::where(['sponsor_id' => $userId])->get();
        if ($NoOfChild){
            $childCount = count($NoOfChild);
        }

        $ownSpent = Order::where(['order_status' => 2, 'user_id' => $userId])->first();
        if ($ownSpent){
            $totalSpent = $ownSpent->order_total;
        }

        $rules = RankRule::where(['rank_id' => $rankId])->get();

        if ($totalSpent != 0 && $childCount != 0 ){
            foreach ($rules as $rule){
                if($rule->ruleId == 1){
                    if ($childCount >= $rule->value1){
                        $child = $childCount;
                    }
                }
                if($rule->ruleId == 2){
                    if ($totalSpent >= $rule->value1){
                        $amount = $totalSpent;
                    }
                }
            }
        }

        if (!empty($child) && !empty($amount)){
            return true;
        }else{
            return false;
        }
    }

    public function settings()
    {
        return view('admin.ranks.settings');
    }
}
