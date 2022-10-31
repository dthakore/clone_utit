<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMtFourBrokerRequest;
use App\Http\Requests\StoreMtFourBrokerRequest;
use App\Http\Requests\UpdateMtFourBrokerRequest;
use App\Models\MtFourBroker;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MtFourBrokersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('mt_four_broker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MtFourBroker::query()->select(sprintf('%s.*', (new MtFourBroker())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'mt_four_broker_show';
                $editGate = 'mt_four_broker_edit';
                $deleteGate = 'mt_four_broker_delete';
                $crudRoutePart = 'mt-four-brokers';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('server_login', function ($row) {
                return $row->server_login ? $row->server_login : '';
            });
            $table->editColumn('server_address', function ($row) {
                return $row->server_address ? $row->server_address : '';
            });
            $table->editColumn('server_port', function ($row) {
                return $row->server_port ? $row->server_port : '';
            });
            $table->editColumn('agent', function ($row) {
                return $row->agent ? $row->agent : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? MtFourBroker::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('comment', function ($row) {
                return $row->comment ? $row->comment : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.mtFourBrokers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('mt_four_broker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mtFourBrokers.create');
    }

    public function store(StoreMtFourBrokerRequest $request)
    {
        $mtFourBroker = MtFourBroker::create($request->all());

        return redirect()->route('admin.mt-four-brokers.index');
    }

    public function edit(MtFourBroker $mtFourBroker)
    {
        abort_if(Gate::denies('mt_four_broker_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mtFourBrokers.edit', compact('mtFourBroker'));
    }

    public function update(UpdateMtFourBrokerRequest $request, MtFourBroker $mtFourBroker)
    {
        $mtFourBroker->update($request->all());

        return redirect()->route('admin.mt-four-brokers.index');
    }

    public function show(MtFourBroker $mtFourBroker)
    {
        abort_if(Gate::denies('mt_four_broker_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.mtFourBrokers.show', compact('mtFourBroker'));
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
