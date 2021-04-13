<?php

namespace App\Tests\Functional\User\Controller;

use App\Tests\Functional\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = $this->createClientForAdmin();
        $this->assertEquals('Hello', $client->getCrawler()->filter('html h1')->first()->text());
    }
}
