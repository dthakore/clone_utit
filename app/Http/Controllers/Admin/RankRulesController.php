<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RankRuleSMap;
use App\Models\Rank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RankRulesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('rank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = RankRuleSMap::with(['rank'])->select(sprintf('%s.*', (new RankRuleSMap())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'rank_show';
                $editGate = 'rank_edit';
                $deleteGate = 'rank_delete';
                $crudRoutePart = 'rankRules';

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
            $table->addColumn('rank_name', function ($row) {
                return $row->rank ? $row->rank->name : '';
            });
            $table->editColumn('key', function ($row) {
                return $row->key ? $row->key : '';
            });
            $table->editColumn('value', function ($row) {
                return $row->value ? $row->value : '';
            });
            $table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'rank']);

            return $table->make(true);
        }

        return view('admin.rankRule.index');
    }

    public function create()
    {
        abort_if(Gate::denies('rank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ranks = Rank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.rankRule.create', compact('ranks'));
    }

    public function store(Request $request)
    {
        $rank = RankRuleSMap::create($request->all());

        return redirect()->route('admin.settings.ranks');
    }

    public function edit(RankRuleSMap $rankRule)
    {
        abort_if(Gate::denies('rank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ranks = Rank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.rankRule.edit', compact('ranks', 'rankRule'));
    }

    public function update(Request $request, RankRuleSMap $rankRule)
    {
        $rankRule->update($request->all());

        return redirect()->route('admin.settings.ranks');
    }

    public function show(RankRuleSMap $rankRule)
    {
        abort_if(Gate::denies('rank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rankRule.show', compact('rankRule'));
    }

    public function destroy(RankRuleSMap $rankRule)
    {
        abort_if(Gate::denies('rank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rankRule->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        RankRuleSMap::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
