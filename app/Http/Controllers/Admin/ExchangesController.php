<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyExchangeRequest;
use App\Http\Requests\StoreExchangeRequest;
use App\Http\Requests\UpdateExchangeRequest;
use App\Models\Exchange;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExchangesController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('exchange_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Exchange::query()->select(sprintf('%s.*', (new Exchange())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'exchange_show';
                $editGate = 'exchange_edit';
                $deleteGate = 'exchange_delete';
                $crudRoutePart = 'exchanges';

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
            $table->editColumn('status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->status ? 'checked' : null) . '>';
            });
            $table->editColumn('is_visible', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_visible ? 'checked' : null) . '>';
            });
            $table->editColumn('tags', function ($row) {
                return $row->tags ? $row->tags : '';
            });
            $table->editColumn('logo', function ($row) {
                if ($photo = $row->logo) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'is_visible', 'logo']);

            return $table->make(true);
        }

        return view('admin.exchanges.index');
    }

    public function create()
    {
        abort_if(Gate::denies('exchange_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.exchanges.create');
    }

    public function store(StoreExchangeRequest $request)
    {
        $exchange = Exchange::create($request->all());

        if ($request->input('logo', false)) {
            $exchange->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $exchange->id]);
        }

        return redirect()->route('admin.exchanges.index');
    }

    public function edit(Exchange $exchange)
    {
        abort_if(Gate::denies('exchange_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.exchanges.edit', compact('exchange'));
    }

    public function update(UpdateExchangeRequest $request, Exchange $exchange)
    {
        $exchange->update($request->all());

        if ($request->input('logo', false)) {
            if (!$exchange->logo || $request->input('logo') !== $exchange->logo->file_name) {
                if ($exchange->logo) {
                    $exchange->logo->delete();
                }
                $exchange->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($exchange->logo) {
            $exchange->logo->delete();
        }

        return redirect()->route('admin.exchanges.index');
    }

    public function show(Exchange $exchange)
    {
        abort_if(Gate::denies('exchange_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.exchanges.show', compact('exchange'));
    }

    public function destroy(Exchange $exchange)
    {
        abort_if(Gate::denies('exchange_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exchange->delete();

        return back();
    }

    public function massDestroy(MassDestroyExchangeRequest $request)
    {
        Exchange::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('exchange_create') && Gate::denies('exchange_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Exchange();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
