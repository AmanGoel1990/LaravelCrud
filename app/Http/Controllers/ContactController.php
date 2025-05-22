<?php

namespace App\Http\Controllers;
use App\Models\Contact;

use Illuminate\Http\Request;



class ContactController extends Controller
{
    // public function importForm()
    // {
    //     return view('contacts.import');
    // }

    public function import(Request $request)
    {
        $request->validate([
        'xml_file' => 'required|file|mimes:xml,txt,text/plain,text/xml',
    ]);

    $file = $request->file('xml_file');

    // Load file contents
    $xmlContent = file_get_contents($file->getRealPath());

    // Parse XML
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
}
