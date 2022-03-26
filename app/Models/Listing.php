<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'base_price', 'expiry_date', 'category_id', 'user_id', 'description', 'media_id', 'all_complete'];

    protected $casts = [
        'expiry_date' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function medias(): BelongsToMany
    {
        return $this->belongsToMany(Media::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function getPictureAttribute()
    {
        if ($this->media_id) return url("/storage/" . $this->media->path);

        return url("/images/no-picture.png");
    }

    public function getLargestBidAttribute()
    {
        $bid = $this->bids()->orderBy('bid_price', 'DESC')->first();
        if ($bid) {
            return $bid->bid_price;
        }

        return null;
    }
}
