<?php

namespace App\Tests\Functional\User\Controller;

use App\Tests\Functional\WebTestCase;
use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        $this->entityManager = self::bootKernel()
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIndex()
    {
        $client = $this->createClientForAdmin();
        $client->request('GET', '/user');
        $this->assertEquals('Users index', $client->getCrawler()->filter('html h1')->first()->text());
    }

    public function testEdit()
    {
        $email = \sprintf('admin_%s@email.ru', \time());
        static::ensureKernelShutdown();
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertEquals('Register', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Register', [
            'registration_form[email]' => $email,
            'registration_form[password]' => '12345678',
        ]);

        $user = $this->findUser(['email' => $email]);
        $this->assertNotNull($user);

        $client = $this->createClientForAdmin();
        $client->request('GET', \sprintf('/user/edit/%d', $user->getId()));
        $this->assertEquals('Edit User', $client->getCrawler()->filter('html h1')->first()->text());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submitForm('Save', [
            'user_edit[roles][0]' => 'ROLE_ADMIN',
        ]);
    }

    public function testDelete()
    {
        $email = \sprintf('admin_%s@email.ru', \time());

        static::ensureKernelShutdown();
        $client = static::createClient();
        $client->request('GET', '/register');
        $this->assertEquals('Register', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Register', [
            'registration_form[email]' => $email,
            'registration_form[password]' => '12345678',
        ]);

        $user = $this->findUser(['email' => $email]);
        $this->assertNotNull($user);

        $client = $this->createClientForAdmin();
        $client->request('GET', \sprintf('/user/edit/%d', $user->getId()));
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submit($client->getCrawler()->filter('#delete-form')->form());
    }

    private function findUser(array $criteria): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy($criteria);
    }
}
