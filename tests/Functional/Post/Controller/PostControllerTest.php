<?php

namespace App\Tests\Functional\Post\Controller;

use App\Post\Entity\Post;
use App\Tests\Functional\WebTestCase;
use App\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class PostControllerTest extends WebTestCase
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

    public function testPostShow()
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

        $title = \sprintf('post%s', \time());
        $text = file_get_contents('/var/www/html/lipsum.txt', true);
        $image = new UploadedFile('/var/www/html/public/test/image.jpg', 'image.jpg', 'image/jpeg', null);

        $client->request('GET', '/post/create');
        $this->assertEquals('Create new Post', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Save', [
            'post[title]' => $title,
            'post[text]' => $text,
            'post[author]' => $user->getId(),
            'post[image]' => $image,
        ]);

        $post = $this->findPost(['title' => $title]);
        $this->assertNotNull($post);

        $client = $this->createClientForAdmin();
        $client->request('GET', \sprintf('/post/%d', $post->getId()));
        $this->assertEquals('Post', $client->getCrawler()->filter('html h1')->first()->text());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $link = $client->getCrawler()->selectLink('Show Comments')->link();
        $client->click($link);
    }

    public function testPostCreate()
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

        $title = \sprintf('post%s', \time());
        $text = file_get_contents('/var/www/html/lipsum.txt', true);
        $image = new UploadedFile('/var/www/html/public/test/image.jpg', 'image.jpg', 'image/jpeg', null);

        $client->request('GET', '/post/create');
        $this->assertEquals('Create new Post', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Save', [
            'post[title]' => $title,
            'post[text]' => $text,
            'post[author]' => $user->getId(),
            'post[image]' => $image,
        ]);
    }

    public function testPostIndex()
    {
        $client = $this->createClientForAdmin();
        $client->request('GET', '/post');
        $this->assertEquals('Post index', $client->getCrawler()->filter('html h1')->first()->text());
        $link = $client->getCrawler()->selectLink('Show')->link();
        $client->click($link);
    }

    public function testPostEdit()
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

        $title = \sprintf('post%s', \time());
        $text = file_get_contents('/var/www/html/lipsum.txt', true);
        $image = new UploadedFile('/var/www/html/public/test/image.jpg', 'image.jpg', 'image/jpeg', null);

        $client->request('GET', '/post/create');
        $client->submitForm('Save', [
            'post[title]' => $title,
            'post[text]' => $text,
            'post[author]' => $user->getId(),
            'post[image]' => $image,
        ]);

        $post = $this->findPost(['title' => $title]);
        $this->assertNotNull($post);

        $client = $this->createClientForAdmin();
        $client->request('GET', \sprintf('/post/%d/edit', $post->getId()));
        $this->assertEquals('Edit Post', $client->getCrawler()->filter('html h1')->first()->text());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submitForm('Update', [
            'post_edit[title]' => $title,
            'post_edit[text]' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.',
            'post_edit[author]' => $user->getId(),
            'post_edit[image]' => $image,
        ]);
    }

    public function testPostDelete()
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

        $title = \sprintf('post%s', \time());
        $text = file_get_contents('/var/www/html/lipsum.txt', true);
        $image = new UploadedFile('/var/www/html/public/test/image.jpg', 'image.jpg', 'image/jpeg', null);

        $client->request('GET', '/post/create');
        $this->assertEquals('Create new Post', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Save', [
            'post[title]' => $title,
            'post[text]' => $text,
            'post[author]' => $user->getId(),
            'post[image]' => $image,
        ]);

        $post = $this->findPost(['title' => $title]);
        $this->assertNotNull($post);

        $client = $this->createClientForAdmin();
        $client->request('GET', \sprintf('/post/%d', $post->getId()));
        $this->assertEquals('Post', $client->getCrawler()->filter('html h1')->first()->text());
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submit($client->getCrawler()->filter('#delete-form')->form());
    }

    public function testPostComments()
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

        $title = \sprintf('post%s', \time());
        $text = file_get_contents('/var/www/html/lipsum.txt', true);
        $image = new UploadedFile('/var/www/html/public/test/image.jpg', 'image.jpg', 'image/jpeg', null);

        $client->request('GET', '/post/create');
        $this->assertEquals('Create new Post', $client->getCrawler()->filter('html h1')->first()->text());
        $client->submitForm('Save', [
            'post[title]' => $title,
            'post[text]' => $text,
            'post[author]' => $user->getId(),
            'post[image]' => $image,
        ]);

        $post = $this->findPost(['title' => $title]);
        $this->assertNotNull($post);

        $client->request('GET', \sprintf('/post/%d/comments', $post->getId()));
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $client->submitForm('Save', [
            'comment[content]' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.',
        ]);
    }

    private function findUser(array $criteria): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy($criteria);
    }

    private function findPost(array $criteria): ?Post
    {
        return $this->entityManager->getRepository(Post::class)->findOneBy($criteria);
    }
}