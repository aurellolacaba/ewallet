<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TransactionTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test */
    public function UserCanNavigateToTransactionPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/dashboard')
                ->click('@transactions-link')
                ->waitForLocation('/transactions')
                ->assertPathIs('/transactions');
        });
    }
}
