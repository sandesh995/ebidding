<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SiteController extends Controller
{
    public function index(): View
    {
        $listings = Listing::with(['category'])->latest()->take(10)->get();

        return view('front.index', compact('listings'));
    }

    public function page(Page $page)
    {
        return view('front.page', compact('page'));
    }

    public function search(Request $request): View|RedirectResponse
    {
        if (empty($request->q)) {
            return redirect('/');
        }

        $search = trim(strip_tags($request->q));

        $listings = Listing::query()
            ->where('name', 'LIKE', '%' . $search . '%')
            ->with(['category'])
            ->latest()
            ->take(10)
            ->get();

        return view('front.index', compact('listings', 'search'));
    }

    public function listings()
    {
        $listings = Listing::query()
            ->latest()
            ->paginate(10);

        return view('front.listings', compact('listings'));
    }

    public function category(Category $category)
    {
        $listings = Listing::query()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(10);
        $title = "Listing by Category: $category->name";

        return view('front.listings', compact('listings', 'category', 'title'));
    }

    public function listing(Listing $listing): View
    {
        $bidding_count = $listing->bids()->count();
        $images = $listing->medias;
        $all_bids = $listing->bids()->orderBy('bid_price', 'DESC')->get();

        $user_listings = $listing->user->listings()->limit(4)->get();

        // Get Similar Listings
        $related_listings = Listing::query()
            ->where('category_id', $listing->category_id)
            ->limit(4)
            ->get();

        return view('front.listing', compact('listing', 'bidding_count', 'all_bids', 'images', 'user_listings', 'related_listings'));
    }

    public function home(): RedirectResponse
    {
        if (auth()->user()?->role == "Admin") {
            return redirect()->route('admin.index');
        }

        return redirect()->route('index');
    }
}
