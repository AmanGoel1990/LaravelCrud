<?php

namespace App\Http\Controllers;
use App\Models\Contact;

use Illuminate\Http\Request;



class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('import_contact', compact('contacts'));
    }

    public function import(Request $request)
    {
        $request->validate([
        'xml_file' => 'required|file|mimes:xml,txt,text/plain,text/xml',
    ]);

    $file = $request->file('xml_file');

    $xmlContent = file_get_contents($file->getRealPath());

    libxml_use_internal_errors(true); // prevent fatal error on invalid XML
    $xml = simplexml_load_string($xmlContent);
    
    if (!$xml) {
        return back()->with('error', 'Invalid XML format.');
    }

    $inserted = 0;

    foreach ($xml->contact as $entry) {
        if (isset($entry->name) && isset($entry->phone)) {
            Contact::create([
                'name' => (string) $entry->name,
                'phone' => (string) $entry->phone,
                'email' => uniqid('import_') . '@example.com', // fallback or dummy email
            ]);
            $inserted++;
        }
    }

    return redirect()->route('contacts.index')->with('success', "$inserted contacts imported successfully!");
    }

    public function edit(Contact $contact)
    {
        return view('edit', compact('contact'));
    }
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
