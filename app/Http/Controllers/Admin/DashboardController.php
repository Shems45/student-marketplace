<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use App\Models\ContactMessage;
use App\Models\Conversation;
use App\Models\Message;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users_total' => User::count(),
            'listings_total' => Listing::count(),
            'listings_active' => Listing::where('is_sold', false)->where('is_reserved', false)->count(),
            'listings_sold' => Listing::where('is_sold', true)->count(),
            'listings_reserved' => Listing::where('is_reserved', true)->count(),
            'listings_featured' => Listing::where('is_featured', true)->count(),
        ];

        // Favorites
        $stats['favorites_total'] = DB::table('favorites')->count();

        // Contact messages
        $stats['contact_total'] = ContactMessage::count();
        $stats['contact_unanswered'] = ContactMessage::whereNull('replied_at')->count();

        // Conversations
        $stats['conversations_total'] = Conversation::count();

        // Messages
        $stats['messages_total'] = Message::count();
        $stats['messages_unread'] = Message::whereNull('read_at')->count();

        return view('admin.dashboard', compact('stats'));
    }
}
