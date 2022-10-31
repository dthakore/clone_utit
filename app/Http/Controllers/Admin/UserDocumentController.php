<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAlert;
use \Mpdf\Mpdf as PDF;
use App\Models\UserDocument;
use App\Models\UserDocumentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UserDocument::get();
            
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('type', function ($row) {
                return  isset(UserDocument::TYPE[$row->type]) ? UserDocument::TYPE[$row->type] : $row->type;
            });
            
            $table->editColumn('status', function ($row) {
                return isset(UserDocument::STATUS[$row->status])? UserDocument::STATUS[$row->status] : $row->status;
            });
            $table->editColumn('actions', function ($row) {
                $viewGate = '';
                $editGate = '';
                $deleteGate = '';
                $crudRoutePart = 'user-documents';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->rawColumns(['actions', 'placeholder']);
            
            return $table->make(true);
        }
        return view('admin.userDocument.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        return view('admin.userDocument.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // generate pdf
        $name = $request->name;
        $account_number = $request->account_number;
        $data =[
            'name'=>$name,
            'account_number'=>$account_number,
            'created_at'    => date("d M Y"),
        ];
        $documentFileName = "Signature_".$request->user_id.".pdf";

        $document = new PDF([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '10',
            'margin_bottom' => '10',
            'margin_footer' => '2',
        ]);

        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"'
        ];
        $document->WriteHTML(view('frontend.digitalSignature.signaturePDF',['data'=>$data]));
        Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "F"));
        $url = url(''.$documentFileName);
        $path = public_path("".$documentFileName);
        
        // end generate pdf
        $user = new UserDocument();
        $user->user_id = $request->user_id;
        $user->name = $name;
        $user->path = $url;
        $user->type = $request->type;
        $user->status = '1';
        $user->comment = '';
        $user->account_number = $request->account_number;
        $user->save();

        $userDocHistory = new UserDocumentHistory();
        $userDocHistory->document_id = $user->id;
        $userDocHistory->comment = '';
        $userDocHistory->status = $user->status;
        $userDocHistory->save();

        $userAlert = new UserAlert();
        $userAlert->alert_text = 'New Document Requested';
        $userAlert->alert_link = '#';
        $userAlert->show_hide = 1;
        $userAlert->type = '2';
        $userAlert->save();
        $userAlert->users()->sync([$request->user_id]);

        return redirect()->route('admin.user-documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
