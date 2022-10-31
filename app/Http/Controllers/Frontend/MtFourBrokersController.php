<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMtFourBrokerRequest;
use App\Http\Requests\StoreMtFourBrokerRequest;
use App\Http\Requests\UpdateMtFourBrokerRequest;
use App\Models\MtFourBroker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MtFourBrokersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mt_four_broker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mtFourBrokers = MtFourBroker::all();

        return view('frontend.mtFourBrokers.index', compact('mtFourBrokers'));
    }

    public function create()
    {
        abort_if(Gate::denies('mt_four_broker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mtFourBrokers.create');
    }

    public function store(StoreMtFourBrokerRequest $request)
    {
        $mtFourBroker = MtFourBroker::create($request->all());

        return redirect()->route('frontend.mt-four-brokers.index');
    }

    public function edit(MtFourBroker $mtFourBroker)
    {
        abort_if(Gate::denies('mt_four_broker_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mtFourBrokers.edit', compact('mtFourBroker'));
    }

    public function update(UpdateMtFourBrokerRequest $request, MtFourBroker $mtFourBroker)
    {
        $mtFourBroker->update($request->all());

        return redirect()->route('frontend.mt-four-brokers.index');
    }

    public function show(MtFourBroker $mtFourBroker)
    {
        abort_if(Gate::denies('mt_four_broker_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.mtFourBrokers.show', compact('mtFourBroker'));
    }

    public function destroy(MtFourBroker $mtFourBroker)
    {
        abort_if(Gate::denies('mt_four_broker_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mtFourBroker->delete();

        return back();
    }

    public function massDestroy(MassDestroyMtFourBrokerRequest $request)
    {
        MtFourBroker::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
