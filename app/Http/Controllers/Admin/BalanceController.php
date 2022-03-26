<?php

namespace App\Http\Controllers\Admin;

use App\Models\Balance;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class BalanceController extends Controller
{
    public function index(): View
    {
        $balances = Balance::with('user')->paginate(20);

        return view('admin.balances.index', compact('balances'));
    }

    public function create(): View
    {
        $users = User::all();

        return view('admin.balances.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id'       => ['required', 'exists:users,id'],
            'amount'        => ['required', 'integer', 'max:9999999'],
            'title'         => ['nullable', 'max:190'],
            'description'   => ['nullable', 'max:10000'],
        ]);

        Balance::create($data);

        return redirect()->route('admin.balances.index')
            ->with('success', 'Balance added!');
    }

    public function show(Balance $balance): View
    {
        return view('admin.balances.show', compact('balance'));
    }
}
