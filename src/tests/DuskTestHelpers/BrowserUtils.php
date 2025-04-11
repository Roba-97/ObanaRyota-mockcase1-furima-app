<?php

namespace Tests\DuskTestHelpers;

use Laravel\Dusk\Browser;

trait BrowserUtils
{
    public function screenshot_whole_page(Browser $browser, string $name)
    {
        $currentSize = $browser->driver->manage()->window()->getSize();
        $browser->fitContent();
        $browser->screenshot($name);
        $browser->driver->manage()->window()->setSize($currentSize);
    }

    public function type_stripe_card_payment_page(Browser $browser)
    {
        $browser->pause(5000)
            ->type('email', 'test@example.com')
            ->type('cardNumber', 4242424242424242)
            ->type('cardExpiry', '04/30')
            ->type('cardCvc', 111)
            ->type('billingName', 'test')
            ->click('button[type="submit"]')
            ->pause(5000);

        return $browser;
    }
}
