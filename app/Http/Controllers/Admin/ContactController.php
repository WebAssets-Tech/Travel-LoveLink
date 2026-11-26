<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-contact|edit-contact|delete-contact', ['only' => ['index', 'show']]);
        $this->middleware('permission:delete-contact', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        return view('admin.contact.index', [
            'contacts' => Contact::latest()->paginate(20),
        ]);
    }

    public function show(Contact $contact): View
    {
        return view('admin.contact.show', compact('contact'));
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.contact.index')->withSuccess('Enquiry deleted successfully.');
    }
}
