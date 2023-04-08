<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class WalletTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function testShouldSeeBalance(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('/dashboard')
                ->assertSee('Php 100.00');
        });
    }

    /** @test */
    public function testCouldSendCredit(): void
    {

        $jane = User::factory()->create()->createWallet();

        $this->browse(function (Browser $browser) use ($jane) {
            
            $browser->loginAs($this->user)
                ->visit('/dashboard')
                ->press('Send')
                ->whenAvailable('#sendCreditModal', function($modal) use ($jane) {
                    $modal->press('#send')
                        ->pause(1000)
                        ->assertSee('The email field is required.')
                        ->assertSee('The amount field is required.');
                });
                
        });
    }
}
