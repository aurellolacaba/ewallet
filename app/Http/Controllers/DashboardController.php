<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use App\Rules\SufficientBalance;
use App\Rules\MustNotEqualToOwnEmail;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();
        $transactions = $user->wallet->transactions()
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'wallet' => [
                'balance' => $user->wallet->balance
            ],
            'transactions' => $transactions
        ]);
    }

    public function send(Request $request) {
        $request->validate([
            'email' => ['required', 'exists:users,email', new MustNotEqualToOwnEmail],
            'amount' => ['required', new SufficientBalance, 'gt:0']
        ]);

        $sender = auth()->user();
        $recipient = User::where('email', $request->email)->first();

        $sender->wallet->sendToUserWithTransaction($recipient, $request->amount);

        return Redirect::to('/dashboard');
    }
}
