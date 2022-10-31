<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoverRequest;
use App\Http\Requests\UpdateCoverRequest;
use App\Http\Resources\Admin\CoverResource;
use App\Models\Cover;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoversApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cover_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoverResource(Cover::with(['bot'])->get());
    }

    public function store(StoreCoverRequest $request)
    {
        $cover = Cover::create($request->all());

        return (new CoverResource($cover))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateCoverRequest $request, Cover $cover)
    {
        $cover->update($request->all());

        return (new CoverResource($cover))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Cover $cover)
    {
        abort_if(Gate::denies('cover_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cover->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
