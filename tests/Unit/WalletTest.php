<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class WalletTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::factory()
            ->create()
            ->createWallet();
    
    }

    /** @test */
    public function could_have_check_if_user_has_wallet_or_has_no_wallet()
    {
        $userTwo = User::factory()->create();

        $this->assertFalse($userTwo->hasWallet());
        $this->assertTrue($this->user->hasWallet());
    }

    /** @test */
    public function a_wallet_should_have_a_balance()
    {   
        $this->assertEquals(0.00, $this->user->wallet->balance);
    }

    /** @test */
    public function wallet_balance_could_be_set()
    {   
        $this->user->wallet->setBalance(500);

        $this->assertEquals(500.00, $this->user->wallet->balance);
    }

    /** @test */
    public function a_wallet_could_send_credits_to_other_wallet()
    {   
        $this->user->wallet->setBalance(500);
        $userTwo = User::factory()->create()->createWallet();

        $this->user->wallet->sendToUser($userTwo, 100);

        $this->assertEquals(400.00, $this->user->wallet->balance);
        $this->assertEquals(100.00, $userTwo->wallet->balance);
    }

    /** @test */
    public function a_wallet_transactions_should_be_logged()
    {   
        $this->user->wallet->setBalance(500);
        $userTwo = User::factory()->create()->createWallet();

        $this->user->wallet->sendToUserWithTransaction($userTwo, 100);

        $this->assertDatabaseHas('transactions', [
            'from' => $this->user->id,
            'to' => $userTwo->id,
            'amount' => 100
        ]);
        $this->assertTrue($this->user->wallet->transactions()->count() > 0);
        $this->assertTrue($userTwo->wallet->transactions()->count() > 0);
    }
    
    /** @test */
    public function a_wallet_could_fetch_transactions()
    {   
        $this->user->wallet->setBalance(500);
        $userTwo = User::factory()->create()->createWallet();

        $this->user->wallet->sendToUserWithTransaction($userTwo, 100);

        $this->assertTrue(!is_null($this->user->wallet->transactions()->get()));
    }
}
