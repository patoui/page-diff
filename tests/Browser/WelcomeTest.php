<?php

declare(strict_types=1);

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class WelcomeTest extends DuskTestCase
{
    public function testWelcome(): void
    {
        $funcName = str_replace(
            '\\',
            '_',
            sprintf('%s_%s', __CLASS__, __FUNCTION__)
        );

        $this->browse(function (Browser $browser) use ($funcName) {
            $browser->visit('/welcome')
                    ->assertSee('Laravel');

            $browser->screenshot($funcName);
            // $browser->responsiveScreenshots($funcName);
        });
    }
}
