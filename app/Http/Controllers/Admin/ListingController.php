<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Media;
use App\Models\Balance;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Notifications\BidLostNotification;
use App\Notifications\BidWinnerNotification;
use App\Notifications\SuccessfulListingNotification;

class ListingController extends Controller
{
    public function index(): View
    {
        $listings = Listing::with(['category', 'user', 'media'])->paginate(20);

        return view('admin.listings.index', compact('listings'));
    }

    public function create(Request $request): View
    {
        $categories = Category::select(['id', 'name'])->get();
        $users = User::select(['id', 'name'])->get();

        return view('admin.listings.create', compact('categories', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'name'          => ['required', 'max:100'],
            'base_price'    => ['required', 'integer', 'min:0'],
            'user_id'       => ['required', 'exists:users,id'],
            'category_id'   => ['required', 'exists:categories,id'],
            'image'         => ['nullable', 'image', 'mimes:jpeg,gif,png'],
            'expiry_date'   => ['nullable', 'date', 'after:' . now()],
            'description'   => ['nullable'],
        ]);

        if ($request->hasFile('image')) {
            $data['media_id'] = MediaService::upload($request->file('image'), "listings");
        }

        // If No Expiry Date (Set it to 1 Month from Now)
        if (empty($request->expiry_date)) {
            $data['expiry_date'] = now()->addMonth(1);
        } else {
            $data['expiry_date'] = Carbon::parse($request->expiry_date);
        }

        Listing::create($data);

        return redirect()->route('admin.listings.index')
            ->with('success', 'New Listing added successfully!');
    }

    public function show(Listing $listing): View
    {
        $images = $listing->medias ?? [];
        $total_bids = $listing->bids()->orderBy('bid_price', 'DESC')->get();

        return view('admin.listings.show', compact('listing', 'images', 'total_bids'));
    }

    public function edit(Listing $listing): View
    {
        $categories = Category::select(['id', 'name'])->get();
        $users = User::select(['id', 'name'])->get();

        return view('admin.listings.edit', compact('listing', 'categories', 'users'));
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        $data = $request->validate([
            'name'          => ['required', 'max:100'],
            'base_price'    => ['required', 'integer', 'min:0'],
            'user_id'       => ['required', 'exists:users,id'],
            'category_id'   => ['required', 'exists:categories,id'],
            'image'         => ['nullable', 'image', 'mimes:jpeg,gif,png'],
            'expiry_date'   => ['nullable', 'date'],
            'description'   => ['nullable'],
        ]);

        // If No Expiry Date (Set it to 1 Month from Now)
        if (empty($request->expiry_date)) {
            $data['expiry_date'] = now()->addMonth(1);
        } else {
            $data['expiry_date'] = Carbon::parse($request->expiry_date);
        }

        if ($request->hasFile('image')) {
            // If already has image, delete it
            if ($listing->media_id && $listing->media) {
                Storage::delete('public/' . $listing->media->path);
            }

            // Upload and Assign New ID
            $data['media_id'] = MediaService::upload($request->file('image'), "listings");
        }

        $listing->update($data);

        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing Updated Successfully!');
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        $listing->delete();

        return redirect()->route('admin.listings.index')
            ->with('success', 'Listing Deleted Successfully!');
    }

    public function search(Request $request)
    {
        if (!$request->has('search') || empty($request->search))
            return redirect()->route('admin.listings.index');

        $search = trim(strip_tags($request->search));

        $listings = Listing::where('name', 'LIKE', '%' . $search . '%')
            ->orderBy('id', 'asc')
            ->paginate(20);

        return view('admin.listings.index', [
            'search' => true,
            'listings' => $listings,
            'search_term' => $search,
        ]);
    }

    public function addImage(Listing $listing, Request $request)
    {
        $request->validate([
            'images'    => ['array'],
            'images.*'  => ['required', 'image', 'mimes:jpeg,png,gif'],
        ]);

        $count = 0;
        foreach ($request->images as $image) {
            $media_id = MediaService::upload($image, "listings");
            $listing->medias()->attach($media_id);
            $count++;
        }

        return redirect()->route('admin.listings.show', $listing)
            ->with('success', "$count images uploaded for this Listing!");
    }

    public function removeImage(Listing $listing, Media $media)
    {
        if (!$listing->medias()->where('id', $media->id)->first()) {
            return redirect()->route('admin.listings.show', $listing)
                ->with('error', 'Invalid request! The image you are trying to delete does not belong to this listing!');
        }

        // Remove Attachment
        $listing->medias()->detach($media->id);

        // Delete Itself
        Storage::delete('public/' . $media->path);
        $media->delete();

        return redirect()->route('admin.listings.show', $listing)
            ->with('success', "Image has been deleted successfully!");
    }

    public function removeCover(Listing $listing)
    {
        if ($listing->media_id && $listing->media) {
            $media = $listing->media;
            $listing->update(['media_id' => null]);    // set null

            // Remove It
            Storage::delete('public/' . $media->path);
            $media->delete();
        }

        return redirect()->route('admin.listings.show', $listing)
            ->with('success', 'Cover image has been deleted successfully!');
    }

    public function handle(Listing $listing)
    {
        if ($listing->expiry_date >= now()) {
            return redirect()->route('admin.listings.show', $listing)
                ->with('error', 'This listing has not expired yet! Payment handle is available only on expired products!');
        }

        $bids = $listing->bids()->orderBy('bid_price', 'DESC')->get();

        return view('admin.listings.handle', compact('listing', 'bids'));
    }

    public function forceExpire(Listing $listing)
    {
        if ($listing->expiry_date > now()) {
            $listing->expiry_date = now();
            $listing->save();
        }

        return redirect()->route('admin.listings.show', $listing)
            ->with('success', 'Listing has been marked as expired!');
    }

    public function complete(Listing $listing)
    {
        if ($listing->all_complete) {
            return redirect()->route('admin.listings.show', $listing)
                ->with('error', 'This listing has already been marked as complete! All the refunds and payment to listing creator has been handled already!');
        }
        if ($listing->expiry_date >= now()) {
            return redirect()->route('admin.listings.show', $listing)
                ->with('error', 'This listing has not expired yet! Payment handle is available only on expired products!');
        }

        $bids = $listing->bids()->orderBy('bid_price', 'DESC')->get();
        $winner = $bids->first();

        // Get All Users
        $refund_users = [];
        foreach ($bids as $bid) {
            // Dont Calculate for Winner
            if ($bid->user_id == $winner->user_id) {
                continue;
            }

            $key = 'USER_' . $bid->user_id;

            // If New Entry Insert and Continue
            if (empty($refund_users[$key])) {
                $refund_users[$key] = [$bid->user_id, $bid->bid_price];
                continue;
            }

            // If Already Has Entry, Check if New is Higher or Not
            if ($refund_users[$key][1] <= $bid->bid_price) {
                $refund_users[$key][1] = $bid->bid_price;
            }
        }

        DB::transaction(function () use ($refund_users, $winner, $listing) {

            // Give Money to Listing Creator [We take 10% CUT]
            $ten_percent = ($winner->bid_price * 0.1);
            $amount = $winner->bid_price - $ten_percent;

            // Refund All User Except Winner
            foreach ($refund_users as $user) {
                Balance::create([
                    'user_id' => $user[0],
                    'amount'  => $user[1],
                    'title'   => 'Refund from Auction of Listing #' . $listing->id,
                    'description' => 'Since you did not win the auction, all the amount deduced on bidding have been refunded to you.',
                ]);

                User::find($user[0])?->notify(new BidLostNotification($listing));
            }

            // Winner Notification
            $winner->user->notify(new BidWinnerNotification($listing));

            $desc = "Congratulations on your successful sales. The highest bid on auction of the listing was Rs. $winner->bid_price!";
            $desc .= " We took our cut of 10% (Rs. $ten_percent) and have funded your wallet with remaining Rs. {{ $amount }}.";
            $desc .= " Thank you for selling your product with us!";
            $listing->user->notify(new SuccessfulListingNotification($listing));

            Balance::create([
                'user_id' => $listing->user_id,
                'amount'  => $amount,
                'title'   => 'Price from Successful Auction of Listing: #' . $listing->id,
                'description' => $desc,
            ]);

            $listing->update(['all_complete' => true]);
        });

        return redirect()->route('admin.listings.show', $listing)
            ->with('success', 'All the payment and refunds for this listing has been handled successfully!');
    }
}
