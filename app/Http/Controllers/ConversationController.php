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
            ->with(['listing', 'buyer', 'seller', 'messages' => function ($q) {
                $q->latest();
            }])
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)->orWhere('seller_id', $userId);
            })
            ->latest('updated_at')
            ->get();

        foreach ($conversations as $c) {
            $lastRead = $c->lastReadAtFor($userId);

            $c->unread_count = $c->messages
                ->where('sender_id', '!=', $userId)
                ->filter(fn($m) => $lastRead === null || $m->created_at->gt($lastRead))
                ->count();

            $c->last_message = $c->messages->first();
            $c->last_direction = $c->last_message
                ? ($c->last_message->sender_id === $userId ? 'sent' : 'received')
                : null;
        }

        $conversations = $conversations
            ->sort(function ($a, $b) {
                $aUnread = $a->unread_count > 0;
                $bUnread = $b->unread_count > 0;

                if ($aUnread !== $bUnread) {
                    return $aUnread ? -1 : 1;
                }

                return $b->updated_at <=> $a->updated_at;
            })
            ->values();

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

        $userId = auth()->id();
        $conversation->markReadFor($userId);

        $conversation->load([
            'listing',
            'buyer',
            'seller',
            'messages.sender',
        ]);

        return view('conversations.show', compact('conversation'));
    }
}
