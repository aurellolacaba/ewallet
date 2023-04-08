<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function testUserCantLoginWithInvalidCredentials(): void
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('#email', 'user@example.com')
                ->type('#password', 'notmypassword')
                ->pressAndWaitFor('#login', 1)
                ->assertPathIs('/login')
                ->assertSee('These credentials do not match our records.');
        });
    }

    /** @test */
    public function testUserCouldLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('#email', $this->user->email)
                ->type('#password', 'password')
                ->press('#login')
                ->waitForLocation('/dashboard')
                ->assertPathIs('/dashboard');
        });
    }

    
}
