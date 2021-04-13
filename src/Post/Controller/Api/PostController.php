<?php

namespace App\Post\Controller\Api;

use App\Post\Entity\Post;
use App\Post\Repository\CommentRepository;
use App\Post\Repository\PostRepository;
use App\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class PostController
 * @package App\Post\Controller\Api
 * @Route("/api", name="post_api")
 */
class PostController extends AbstractController
{
    /**
     * @param PostRepository $postRepository
     * @return JsonResponse
     * @Route("/posts", name="posts", methods={"GET"})
     */
    public function getPosts(PostRepository $postRepository)
    {
        $data = $postRepository->findAll();

        return $this->response($data);
    }

    /**
     * @param PostRepository $postRepository
     * @param $id
     * @return JsonResponse
     * @Route("/post/{id}", name="post_show", methods={"GET"})
     */
    public function getShowPost(PostRepository $postRepository, $id)
    {
        $data = $postRepository->find($id);

        return $this->response($data);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PostRepository $postRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route("/post/add", name="post_add", methods={"POST"})
     */
    public function addPost(Request $request, EntityManagerInterface $entityManager,
                            PostRepository $postRepository, UserRepository $userRepository)
    {
        $user = $userRepository->find($request->get('user_id'));
        try{
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('title') || !$request->request->get('text')){
                throw new \Exception();
            }

            $post = new Post();
            $post->setTitle($request->get('title'));
            $post->setText($request->get('text'));
            $post->setPublishedAt(new \DateTime());
            $post->setAuthor($user);

            $entityManager->persist($post);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Post added successfully",
            ];
            return $this->response($data);

        }catch (\Exception $e){
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param PostRepository $postRepository
     * @param UserRepository $userRepository
     * @param $id
     * @return JsonResponse
     * @Route("/post/update/{id}", name="post_update", methods={"POST"})
     */
    public function updatePost(Request $request, EntityManagerInterface $entityManager,
                               PostRepository $postRepository, UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($request->get('user_id'));
        try{
            $post = $postRepository->find($id);

            if (!$post){
                $data = [
                    'status' => 404,
                    'errors' => "Post not found",
                ];
                return $this->response($data, 404);
            }

            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('title') || !$request->request->get('text')){
                throw new \Exception();
            }

            $post->setTitle($request->get('title'));
            $post->setText($request->get('text'));
            $post->setPublishedAt(new \DateTime());
            $post->setAuthor($user);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'errors' => "Post updated successfully",
            ];
            return $this->response($data);

        }catch (\Exception $e){
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param PostRepository $postRepository
     * @param $id
     * @return JsonResponse
     * @Route("/post/delete/{id}", name="posts_delete", methods={"DELETE"})
     */
    public function deletePost(EntityManagerInterface $entityManager, PostRepository $postRepository, $id)
    {
        $post = $postRepository->find($id);

        if (!$post){
            $data = [
                'status' => 404,
                'errors' => "Post not found",
            ];
            return $this->response($data, 404);
        }

        $entityManager->remove($post);
        $entityManager->flush();
        $data = [
            'status' => 200,
            'errors' => "Post deleted successfully",
        ];
        return $this->response($data);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param PostRepository $postRepository
     * @param $id
     * @return JsonResponse
     * @Route("/post/{id}/comments", name="posts_show_comments", methods={"GET"})
     */
    public function getPostShowComments(EntityManagerInterface $entityManager, PostRepository $postRepository, $id)
    {
        $post = $postRepository->find($id);

        return $this->response($post->getComments()->toArray());
    }

    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}