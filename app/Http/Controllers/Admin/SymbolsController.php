<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Symbol;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SymbolsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('symbol_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $symbols = Symbol::all();

        return view('admin.symbols.index', compact('symbols'));
    }
}
