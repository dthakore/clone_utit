@extends('layouts.frontend-new', [
    "title" => "My Documents",
    "breadcrumbs" => [
        [
            "title" => "Home",
            "url" => "#"
        ],
        [
            "title" => "My Documents"
        ]
    ]
])
@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

<style>
    .form-group .form-control{
        border: 1px solid #727171;
    }
    .kbw-signature { width: 350px; height: 200px;}
    
</style>
@endsection
@section('content')
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-body">
                @if(request()->get('status'))
                    <div class="alert alert-solid-info alert-dismissible fade show" role="alert">
                        <!-- <strong>Heads up!</strong>  -->
                        Your document is updated with requested details
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                @endif
                @if(!$userDocuments->isEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-nowrap border-bottom" id="responsive-datatable">
                        <thead>
                        <tr>
                            <th class="wd-5p">
                                ID
                            </th>
                            <th class="wd-25p">
                                Name
                            </th>
                            <th class="wd-15p">
                                Type
                            </th>
                            <th class="wd-15p">
                                Status
                            </th>
                            <th class="wd-20p">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($userDocuments as $userDocument)
                            <tr>
                                <td>
                                    {{$userDocument->id}}
                                </td>
                                <td>
                                    {{$userDocument->name}}
                                </td>
                                <td>
                                    {{ App\Models\UserDocument::TYPE[$userDocument->type] ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\UserDocument::STATUS[$userDocument->status] ?? '' }}
                                </td>
                                <td>
                                    <input type="hidden" class="clsDoc" value="{{$userDocument->id}}" />
                                    <input type="hidden" class="name" value="{{$userDocument->name}}" />
                                    <input type="hidden" class="account_number" value="{{$userDocument->account_number}}" />
                                    <a class="btn btn-primary btn-sm btnProcess" href="" data-bs-target="#exampleModal" data-bs-toggle="modal">
                                        <i class="fas fa-sync-alt">
                                        </i>
                                        Process
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="{{$userDocument->path}}" target="_blank">
                                        <i class="fas fa-download">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="alert alert-default">
                        No Documents Found.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" action="{{ route("frontend.document.store") }}" enctype="multipart/form-data" id="user-form">
        @csrf
        <input type="hidden" name="doc_id" class="modelDocId" value="" />
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Process Document</h5>
            <button type="button" class="close " data-bs-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">{{ trans('cruds.userDocument.fields.user_name') }}</label>
                        <input class="form-control doc_name {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="account_number">{{ trans('cruds.userDocument.fields.account_number') }}</label>
                        <input class="form-control account_number {{ $errors->has('account_number') ? 'is-invalid' : '' }}" type="text" name="account_number" id="account_number" value="{{ old('account_number', '') }}">
                        @if($errors->has('account_number'))
                            <div class="invalid-feedback">
                                {{ $errors->first('account_number') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    <label class="" for="">Signature:</label>
                    <br/>
                    <div id="sig" ></div>
                    <br/>
                    <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                    <textarea id="signature64" name="signed" style="display: none"></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </div>
        </div>
    </form>
  </div>
@endsection

@section('scripts')
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/js/jquery.signature.js')}}"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>
var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });

    $('.btnProcess').click(function(e) {
       var doc_id =  $(this).parent('td').find('.clsDoc').val();
       var doc_name =  $(this).parent('td').find('.name').val();
       var account_number =  $(this).parent('td').find('.account_number').val();
       $('.modelDocId').val(doc_id);
       $('.doc_name').val(doc_name);
       $('.account_number').val(account_number);
        e.preventDefault();
        
    });

    $(document).ready(function() {
        $("#user-form").validate({
            rules: {
                'name': {
                    required: true,
                },
                'account_number': {
                    required: true,
                    number: true,
                },
            },
            messages: {
                'name': {
                    required: "Name is required",
                },
                'account_number': {
                    required: "Account is required",
                    number: "Please enter Valid Account Number",
                },
            },
        });
    });
</script>
@endsection