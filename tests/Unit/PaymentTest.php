<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Services\Payment\Strategies\Paypal;
use Mockery\MockInterface;
use App\Services\Payment\Payment as PaymentService;

class PaymentTest extends TestCase
{
    
    use DatabaseTransactions;

    /** @test */
    public function should_return_redirect_url_to_paypal(): void
    {
        $this->mock(
            Paypal::class, function (MockInterface $mock) {
                $mock->shouldReceive('pay')->andReturns('https://www.sandbox.paypal.com/checkoutnow?token=60W5210888054561R'); 
        });

        $payment = new PaymentService('paypal');
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
        $redirect_url = $payment->arguments($args)
            ->pay();

        $this->assertEquals(
            'https://www.sandbox.paypal.com/checkoutnow?token=60W5210888054561R', 
            $redirect_url
        );
    }
}
