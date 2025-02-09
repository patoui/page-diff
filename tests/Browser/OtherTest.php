<?php

declare(strict_types=1);

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class OtherTest extends DuskTestCase
{
    public function testOther(): void
    {
        $funcName = str_replace(
            '\\',
            '_',
            sprintf('%s_%s', __CLASS__, __FUNCTION__)
        );

        $this->browse(function (Browser $browser) use ($funcName) {
            $browser->visit('/other')
                    ->assertSee('OTHER');

            $browser->screenshot($funcName);
            // $browser->responsiveScreenshots($funcName);
        });
    }
}
