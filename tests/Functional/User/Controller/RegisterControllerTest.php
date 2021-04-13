<?php

namespace App\Tests\Functional\User\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegister()
    {
        $client = static::createClient();

        $client->request('GET', '/register');
        $this->assertEquals('Register', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Register', [
            'registration_form[email]' => \sprintf('admin_%s@email.ru', \time()),
            'registration_form[password]' => '12345678',
        ]);
    }
}
