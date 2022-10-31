<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDocument;
use App\Models\UserDocumentHistory;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    public function list()
    {
        $userDocuments = UserDocument::where('user_id',auth()->user()->id)->get();
        return view('frontend.userDocument.list',compact('userDocuments'));
    }

    public function updateStore(Request $request)
    {
        $name = $request->name;
        $account_number = $request->account_number;
        $doc_id =  $request->doc_id;
        $image =  $request->signed;
        $data =[
            'name' =>$name,
            'account_number' =>$account_number,
            'img'   => $image,
            'created_at' => date("d M Y"),
        ];
        $documentFileName = "Signature_".$doc_id.".pdf";

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
    
        UserDocument::where('id', $doc_id)->update(
            [
                'name' => $name,
                'path' => $url,
                'status' => 2,
                'account_number' => $account_number
            ]);

        $userDocHistory = new UserDocumentHistory();
        $userDocHistory->document_id = $doc_id;
        $userDocHistory->comment = '';
        $userDocHistory->status = 2;
        $userDocHistory->save();

        $userDocuments = UserDocument::where('user_id',auth()->user()->id)->get();
        
        return redirect()->route('frontend.documents', ['status' => 'success']);

    }
}
