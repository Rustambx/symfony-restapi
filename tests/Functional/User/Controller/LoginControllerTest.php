<?php

namespace App\Tests\Functional\User\Controller;

use App\Tests\Functional\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = $this->createClientForAdmin();
        $this->assertEquals('Hello', $client->getCrawler()->filter('h1')->first()->text());
    }
}
