<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $messages = ContactMessage::query()
            ->when($q, fn ($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('subject', 'like', "%{$q}%")
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contact_messages.index', compact('messages', 'q'));
    }

    public function show(ContactMessage $contactMessage)
    {
        return view('admin.contact_messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('status', 'Message deleted.');
    }
}
