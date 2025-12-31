<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Listing;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $conversations = Conversation::query()
            ->with(['listing', 'buyer', 'seller'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest('updated_at')
            ->get();

        return view('conversations.index', compact('conversations', 'userId'));
    }

    public function start(Listing $listing)
    {
        // seller = listing owner
        $sellerId = $listing->user_id;
        $buyerId = auth()->id();

        if ($buyerId === $sellerId) {
            return back()->with('status', 'You cannot message yourself.');
        }

        $conversation = Conversation::firstOrCreate([
            'listing_id' => $listing->id,
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $conversation->load([
            'listing',
            'buyer',
            'seller',
            'messages.sender',
        ]);

        return view('conversations.show', compact('conversation'));
    }
}
