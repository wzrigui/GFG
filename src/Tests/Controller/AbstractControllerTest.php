<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

abstract class AbstractControllerTest extends WebTestCase
{
    /** @var KernelBrowser $client */
    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }
}
