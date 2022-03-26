<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Balance;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function create()
    {
        if (auth()->user()?->role != "User") {
            return abort(403, "Admin cannot add new listing!");
        }

        $categories = Category::all();

        return view('front.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (auth()->user()?->role != "User") {
            return abort(403, "Admin cannot add new listing!");
        }

        $data = $request->validate([
            'name'          => ['required', 'max:100'],
            'base_price'    => ['required', 'integer', 'min:0'],
            'category_id'   => ['required', 'exists:categories,id'],
            'image'         => ['required', 'image', 'mimes:jpeg,gif,png'],
            'images'        => ['nullable', 'array'],
            'images.*'      => ['nullable', 'image', 'mimes:jpeg,gif,png'],
            'description'   => ['required'],
        ]);

        // Upload Image
        if ($request->hasFile('image')) {
            $data['media_id'] = MediaService::upload($request->file('image'), "listings");
        }

        $data['user_id'] = auth()->id();
        $data['expiry_date'] = now()->addDays(30);

        $listing = Listing::create($data);

        // Upload Remaining Cover Images
        if (!empty($request->images)) {
            foreach ($request->images as $image) {
                $media_id = MediaService::upload($image, "listings");
                $listing->medias()->attach($media_id);
            }
        }

        return redirect()->route('front.listing', $listing)
            ->with('success', 'New Listing has been added successfully!');
    }

    public function bid(Request $request, Listing $listing)
    {
        $high_price = $listing->largest_bid ?? $listing->base_price;
        $request->validate([
            'amount' => ['required', 'integer', 'min:' . $high_price],
        ]);

        if (auth()->id() == $listing->user_id) {
            return redirect()->route('front.listing', $listing)
                ->with('error', 'You cannot bid on your own listing!');
        }

        if ($listing->expiry_date <= now()) {
            return redirect()->route('front.listing', $listing)
                ->with('error', 'Bidding duration for this listing has expired!');
        }

        // Check Highest Bid Amount
        $bid = Bid::where('listing_id', $listing->id)
            ->orderBy('bid_price', 'DESC')
            ->first();

        if ($bid && ($request->amount < $bid->bid_price)) {
            return redirect()->route('front.listing', $listing)
                ->with('error', 'Your bid should be higher that current higest bid of Rs. ' . $bid->bid_price . '!');
        }

        // Deduce Balance and Create Bid
        $check_balance = Balance::where('user_id', auth()->id())
            ->sum('amount');

        // Get Older Bids from This User
        $last_bid = Bid::query()
            ->where('user_id', auth()->id())
            ->where('listing_id', $listing->id)
            ->orderBy('bid_price', 'DESC')
            ->first();

        $amt_to_pay = $request->amount;
        $desc = "Deduced for bidding on listing #$listing->id. ";

        if ($last_bid) {
            $amt_to_pay = $request->amount - $last_bid->bid_price;
            $desc .= "Deduced amount Rs. $amt_to_pay out of Rs. $request->amount since you have already bid Rs. $last_bid->bid_price for this listing.";
            if ($check_balance < $amt_to_pay) {
                return redirect()->route('front.listing', $listing)
                    ->with('error', 'You do not have sufficient balance in your account to bid for this listing!');
            }
        } else {
            $desc .= "Deduced Amount Rs. $amt_to_pay for this bid.";
            if ($check_balance < $amt_to_pay) {
                return redirect()->route('front.listing', $listing)
                    ->with('error', 'You do not have sufficient balance in your account to bid for this listing!');
            }
        }

        DB::transaction(function () use ($amt_to_pay, $listing, $desc, $request) {
            Balance::create([
                'user_id'       => auth()->id(),
                'amount'        => $amt_to_pay * -1,
                'title'         => 'For Bidding on Listing #' . $listing->id,
                'description'   => $desc,
            ]);

            Bid::create([
                'listing_id'    => $listing->id,
                'user_id'       => auth()->id(),
                'bid_price'    => $request->amount,
            ]);
        });

        return redirect()->route('front.listing', $listing)
            ->with('success', 'You have successfully placed a bid for this listing!');
    }

    public function balance()
    {
        $history = Balance::where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->get();
        $balance = auth()->user()->current_balance;

        return view('front.balance', compact('balance', 'history'));
    }
    public function balanceInfo(Balance $balance)
    {
        if ($balance->user_id != auth()->id()) {
            abort(403);
        }

        return view('front.balance-info', compact('balance'));
    }

    public function topup()
    {
        $balance = auth()->user()->current_balance;

        return view('front.topup', compact('balance'));
    }
}
