<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRankRequest;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Models\Rank;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RanksController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('rank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ranks = Rank::with(['media'])->get();

        return view('frontend.ranks.index', compact('ranks'));
    }

    public function create()
    {
        abort_if(Gate::denies('rank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.ranks.create');
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

        return redirect()->route('frontend.ranks.index');
    }

    public function edit(Rank $rank)
    {
        abort_if(Gate::denies('rank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.ranks.edit', compact('rank'));
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

        return redirect()->route('frontend.ranks.index');
    }

    public function show(Rank $rank)
    {
        abort_if(Gate::denies('rank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rank->load('rankUsers');

        return view('frontend.ranks.show', compact('rank'));
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
}
