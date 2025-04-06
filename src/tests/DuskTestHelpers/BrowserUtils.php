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
}
