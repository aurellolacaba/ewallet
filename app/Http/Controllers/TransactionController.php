<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index(){
        $transactions = auth()->user()->wallet
            ->transactions()
            ->with('from', 'to')
            ->latest()
            ->get();

        return Inertia::render('Transaction', compact('transactions'));
    }
}
