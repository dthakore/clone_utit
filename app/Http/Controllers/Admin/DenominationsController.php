<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDenominationRequest;
use App\Http\Requests\StoreDenominationRequest;
use App\Http\Requests\UpdateDenominationRequest;
use App\Models\Denomination;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DenominationsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('denomination_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Denomination::query()->select(sprintf('%s.*', (new Denomination())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'denomination_show';
                $editGate = 'denomination_edit';
                $deleteGate = 'denomination_delete';
                $crudRoutePart = 'denominations';

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
            $table->editColumn('denomination_type', function ($row) {
                return $row->denomination_type ? $row->denomination_type : '';
            });
            $table->editColumn('sub_type', function ($row) {
                return $row->sub_type ? $row->sub_type : '';
            });
            $table->editColumn('label', function ($row) {
                return $row->label ? $row->label : '';
            });
            $table->editColumn('currency', function ($row) {
                return $row->currency ? $row->currency : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.denominations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('denomination_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.denominations.create');
    }

    public function store(StoreDenominationRequest $request)
    {
        $denomination = Denomination::create($request->all());

        return redirect()->route('admin.denominations.index');
    }

    public function edit(Denomination $denomination)
    {
        abort_if(Gate::denies('denomination_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.denominations.edit', compact('denomination'));
    }

    public function update(UpdateDenominationRequest $request, Denomination $denomination)
    {
        $denomination->update($request->all());

        return redirect()->route('admin.denominations.index');
    }

    public function show(Denomination $denomination)
    {
        abort_if(Gate::denies('denomination_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.denominations.show', compact('denomination'));
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
