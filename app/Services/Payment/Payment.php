<?php

namespace App\Services\Payment;

use App\Services\Payment\Interfaces\PaymentMethod;
use App\Services\Payment\Strategies\Paypal;

class Payment {

    private PaymentMethod $payment_strategy;
    private $arguments = NULL;

    public function __construct(string $payment_method = 'paypal'){
        $strategy_lookup = [
            'paypal' => app(Paypal::class)
        ];

        $this->payment_strategy = $strategy_lookup[$payment_method] ??
            throw new \InvalidArgumentException('payment method is invalid');
    }

    public function arguments(array $args) {
        $this->arguments = $args;

        return $this;
    }

    public function pay() {
        if(is_null($this->arguments)) return 'arguments cannot be empty';
        
        return $this->payment_strategy->pay($this->arguments);
    }

}