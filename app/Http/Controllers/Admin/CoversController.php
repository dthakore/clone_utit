<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCoverRequest;
use App\Http\Requests\StoreCoverRequest;
use App\Http\Requests\UpdateCoverRequest;
use App\Models\Bot;
use App\Models\Cover;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoversController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cover_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $covers = Cover::with(['bot'])->get();

        return view('admin.covers.index', compact('covers'));
    }

    public function create()
    {
        abort_if(Gate::denies('cover_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bots = Bot::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.covers.create', compact('bots'));
    }

    public function store(StoreCoverRequest $request)
    {
        $cover = Cover::create($request->all());

        return redirect()->route('admin.covers.index');
    }

    public function edit(Cover $cover)
    {
        abort_if(Gate::denies('cover_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bots = Bot::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cover->load('bot');

        return view('admin.covers.edit', compact('bots', 'cover'));
    }

    public function update(UpdateCoverRequest $request, Cover $cover)
    {
        $cover->update($request->all());

        return redirect()->route('admin.covers.index');
    }

    public function destroy(Cover $cover)
    {
        abort_if(Gate::denies('cover_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cover->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoverRequest $request)
    {
        Cover::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
