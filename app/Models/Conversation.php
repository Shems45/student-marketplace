<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Conversation extends Model
{
    protected $fillable = ['listing_id', 'buyer_id', 'seller_id'];

    protected $casts = [
        'buyer_last_read_at' => 'datetime',
        'seller_last_read_at' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastReadAtFor(int $userId): ?Carbon
    {
        if ($userId === $this->buyer_id) return $this->buyer_last_read_at;
        if ($userId === $this->seller_id) return $this->seller_last_read_at;
        return null;
    }

    public function markReadFor(int $userId): void
    {
        if ($userId === $this->buyer_id) {
            $this->buyer_last_read_at = now();
            $this->save();
        } elseif ($userId === $this->seller_id) {
            $this->seller_last_read_at = now();
            $this->save();
        }
    }
}
