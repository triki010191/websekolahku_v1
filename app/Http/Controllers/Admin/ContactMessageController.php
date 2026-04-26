<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query()->latest();
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->q) {
            $q = '%'.$request->q.'%';
            $query->where(function ($b) use ($q) {
                $b->where('name', 'like', $q)
                    ->orWhere('email', 'like', $q)
                    ->orWhere('subject', 'like', $q);
            });
        }
        $messages = $query->paginate(25)->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        if ($contactMessage->status === 'new') {
            $contactMessage->update(['status' => 'read']);
        }

        return view('admin.contact-messages.show', ['message' => $contactMessage]);
    }

    public function updateStatus(Request $request, ContactMessage $contactMessage)
    {
        $request->validate(['status' => ['required', 'in:new,read,replied']]);
        $contactMessage->update(['status' => $request->status]);

        return back()->with('success', 'Status disimpan.');
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('success', 'Pesan dihapus.');
    }
}
