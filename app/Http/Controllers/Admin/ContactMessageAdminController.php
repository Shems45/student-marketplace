<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function reply(ContactMessage $contactMessage)
    {
        $data = request()->validate([
            'admin_reply' => ['required', 'string', 'min:2'],
        ]);

        $contactMessage->update([
            'admin_reply' => $data['admin_reply'],
            'replied_at' => now(),
        ]);

        Mail::raw($data['admin_reply'], function ($m) use ($contactMessage) {
            $m->to($contactMessage->email)
              ->subject('Re: Your message to Student Marketplace');
        });

        return back()->with('status', 'Reply sent.');
    }
}
