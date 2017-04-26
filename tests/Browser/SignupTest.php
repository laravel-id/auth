<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SignupTest extends DuskTestCase
{
    public function testSignupForm()
    {
        $this->browse(function(Browser $browser) {
            // $browser->visit('/signup')
            //     ->assertSee('Sign Up');
        });
    }

    public function testSignup()
    {
        $this->browse(function(Browser $browser){
            $browser->visit('/signup')
                ->type('name', 'test')
                ->type('email', 'test@email.com')
                ->type('password', 'secretpassword')
                ->type('confirm_password', 'secretpassword')
                ->press('Sign Up')
                ->assertPathIs('/home');
        });
    }
}
