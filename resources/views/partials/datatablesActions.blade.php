@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
        {{ trans('global.view') }}
    </a>
@endcan
@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
        {{ trans('global.edit') }}
    </a>
@endcan
@if(isset($autoLogin))
        <a class="btn btn-xs btn-secondary" href="{{ route('admin.' . $crudRoutePart . '.login', $row->id) }}" target="_blank">
            <i class="fas fa-sign-in-alt" aria-hidden="true"></i>
        </a>
    @endif
@isset($treeGate)
    <a class="btn btn-xs btn-success" href="{{ route('admin.' . $crudRoutePart . '.tree', $row->id) }}">
        Tree View
    </a>
@endisset
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
