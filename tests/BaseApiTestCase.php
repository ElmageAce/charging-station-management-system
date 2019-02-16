<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class BaseApiTestCase extends TestCase
{
    use DatabaseTransactions;
}
