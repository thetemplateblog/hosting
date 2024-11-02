<?php

namespace Thetemplateblog\Hosting\Tests;

use Thetemplateblog\Hosting\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
