<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContactContactRequest;
use App\Http\Requests\StoreContactContactRequest;
use App\Http\Requests\UpdateContactContactRequest;
use App\Models\ContactCompany;
use App\Models\ContactContact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ContactContactsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('contact_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ContactContact::with(['company'])->select(sprintf('%s.*', (new ContactContact())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'contact_contact_show';
                $editGate = 'contact_contact_edit';
                $deleteGate = 'contact_contact_delete';
                $crudRoutePart = 'contact-contacts';

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
            $table->addColumn('company_company_name', function ($row) {
                return $row->company ? $row->company->company_name : '';
            });

            $table->editColumn('contact_first_name', function ($row) {
                return $row->contact_first_name ? $row->contact_first_name : '';
            });
            $table->editColumn('contact_last_name', function ($row) {
                return $row->contact_last_name ? $row->contact_last_name : '';
            });
            $table->editColumn('contact_phone_1', function ($row) {
                return $row->contact_phone_1 ? $row->contact_phone_1 : '';
            });
            $table->editColumn('contact_phone_2', function ($row) {
                return $row->contact_phone_2 ? $row->contact_phone_2 : '';
            });
            $table->editColumn('contact_email', function ($row) {
                return $row->contact_email ? $row->contact_email : '';
            });
            $table->editColumn('contact_skype', function ($row) {
                return $row->contact_skype ? $row->contact_skype : '';
            });
            $table->editColumn('contact_address', function ($row) {
                return $row->contact_address ? $row->contact_address : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'company']);

            return $table->make(true);
        }

        $contact_companies = ContactCompany::get();

        return view('admin.contactContacts.index', compact('contact_companies'));
    }

    public function create()
    {
        abort_if(Gate::denies('contact_contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = ContactCompany::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.contactContacts.create', compact('companies'));
    }

    public function store(StoreContactContactRequest $request)
    {
        $contactContact = ContactContact::create($request->all());

        return redirect()->route('admin.contact-contacts.index');
    }

    public function edit(ContactContact $contactContact)
    {
        abort_if(Gate::denies('contact_contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = ContactCompany::pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contactContact->load('company');

        return view('admin.contactContacts.edit', compact('companies', 'contactContact'));
    }

    public function update(UpdateContactContactRequest $request, ContactContact $contactContact)
    {
        $contactContact->update($request->all());

        return redirect()->route('admin.contact-contacts.index');
    }

    public function show(ContactContact $contactContact)
    {
        abort_if(Gate::denies('contact_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactContact->load('company');

        return view('admin.contactContacts.show', compact('contactContact'));
    }

    public function destroy(ContactContact $contactContact)
    {
        abort_if(Gate::denies('contact_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactContact->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactContactRequest $request)
    {
        ContactContact::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
