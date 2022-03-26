<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['listing_id', 'user_id', 'bid_price'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
