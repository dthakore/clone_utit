<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDenominationRequest;
use App\Http\Requests\StoreDenominationRequest;
use App\Http\Requests\UpdateDenominationRequest;
use App\Models\Denomination;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DenominationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('denomination_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $denominations = Denomination::all();

        return view('frontend.denominations.index', compact('denominations'));
    }

    public function create()
    {
        abort_if(Gate::denies('denomination_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.denominations.create');
    }

    public function store(StoreDenominationRequest $request)
    {
        $denomination = Denomination::create($request->all());

        return redirect()->route('frontend.denominations.index');
    }

    public function edit(Denomination $denomination)
    {
        abort_if(Gate::denies('denomination_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.denominations.edit', compact('denomination'));
    }

    public function update(UpdateDenominationRequest $request, Denomination $denomination)
    {
        $denomination->update($request->all());

        return redirect()->route('frontend.denominations.index');
    }

    public function show(Denomination $denomination)
    {
        abort_if(Gate::denies('denomination_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.denominations.show', compact('denomination'));
    }

    public function destroy(Denomination $denomination)
    {
        abort_if(Gate::denies('denomination_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $denomination->delete();

        return back();
    }

    public function massDestroy(MassDestroyDenominationRequest $request)
    {
        Denomination::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
