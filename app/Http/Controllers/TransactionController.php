<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index(Request $request){
        $limit = $request->limit ?? 10;

        $transactions = auth()->user()->wallet
            ->transactions()
            ->with('from', 'to')
            ->latest()
            ->paginate($limit)
            ->withQueryString();

        return Inertia::render('Transaction', compact('transactions'));
    }
}
