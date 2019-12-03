<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AttributionsPDFTest extends DuskTestCase
{
    /**
     *  download the pdf and checks if it's present at the given location
     */
    public function test_topdf_success() {}

    /**
     * download the pdf and checks if it isn't empty
     */
    public function test_topdf_not_empty() {}
}
