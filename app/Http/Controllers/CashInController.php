<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payment\Payment;
use Inertia\Inertia;

class CashInController extends Controller
{
    public function index(Payment $payment){
        $args = [
            'amount' => 100,
            'billing' => [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ],
            'metadata' => [
                'reference_id' => 'd9f80740-38f0-11e8-b467-0ed5f89f718b'
            ]
        ];

        $redirect_url = $payment->arguments($args)->pay();

        return Inertia::location($redirect_url);
    }
}
