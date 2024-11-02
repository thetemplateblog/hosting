<?php

namespace TheTemplateBlog\Hosting\Tests;

use TheTemplateBlog\Hosting\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
