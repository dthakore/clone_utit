<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AuditLogsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('audit_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $start = '';
            $end = '';
            $query = AuditLog::query()->select(sprintf('%s.*', (new AuditLog())->table));

            if ($request->has('user_id') && $request->get('user_id') != null) {
                $query->where("user_id", $request->get('user_id'));
            }
            if ($request->has('user_name') && $request->get('user_name') != null) {
                $name = explode(" ~ ", $request->get('user_name'));
                $query->where("user_name", "like", "%{$name[0]}%");
            }
            if ($request->has('user_email') && $request->get('user_email') != null) {
                $query->where("user_email", "like", "%{$request->get('user_email')}%");
            }
            if ($request->has('model_name') && $request->get('model_name') != null) {
                $query->where("model_name", "like", "%{$request->get('model_name')}%");
            }
            if($request->get('start_date') != null){
                $start = date('Y-m-d 00:00:00',strtotime($request->get('start_date')));
            }
            if($request->get('end_date') != null){
                $end = date('Y-m-d 23:59:59',strtotime($request->get('end_date')));
            }
            if ($start != '' && $end != '') {
                $query->whereBetween('created_at', [$start, $end]);
            } else if ($start != '') {
                $query->where("created_at", "like", "%{$start}%");
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'audit_log_show';
                $editGate = 'audit_log_edit';
                $deleteGate = 'audit_log_delete';
                $crudRoutePart = 'audit-logs';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('subject_id', function ($row) {
                return $row->subject_id ? $row->subject_id : '';
            });
            $table->editColumn('subject_type', function ($row) {
                return $row->subject_type ? $row->subject_type : '';
            });
            $table->editColumn('model_name', function ($row) {
                return $row->model_name ? $row->model_name : '';
            });
            $table->editColumn('user_id', function ($row) {
                return $row->user_id ? $row->user_id : '';
            });
            $table->editColumn('user_name', function ($row) {
                return $row->user_name ? $row->user_name : '';
            });
            $table->editColumn('user_email', function ($row) {
                return $row->user_email ? $row->user_email : '';
            });
            $table->editColumn('action', function ($row) {
                return $row->action ? $row->action : '';
            });
            $table->editColumn('host', function ($row) {
                return $row->host ? $row->host : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.auditLogs.index');
    }

    public function show(AuditLog $auditLog)
    {
        abort_if(Gate::denies('audit_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.auditLogs.show', compact('auditLog'));
    }
}
