<?php

declare(strict_types=1);

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AboutTest extends DuskTestCase
{
    public function testAbout(): void
    {
        $funcName = str_replace(
            '\\',
            '_',
            sprintf('%s_%s', __CLASS__, __FUNCTION__)
        );

        $this->browse(function (Browser $browser) use ($funcName) {
            $browser->visit('/about')
                    ->assertSee('ABOUT');

            $browser->screenshot($funcName);
            // $browser->responsiveScreenshots($funcName);
        });
    }
}
