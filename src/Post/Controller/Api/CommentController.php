<?php

namespace App\Post\Controller\Api;

use App\Post\Entity\Comment;
use App\Post\Repository\CommentRepository;
use App\Post\Repository\PostRepository;
use App\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @package App\Post\Controller\Api
 * @Route("/api", name="comment_api")
 */
class CommentController extends AbstractController
{
    /**
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     * @Route("/comments", name="comments", methods={"GET"})
     */
    public function getComments(CommentRepository $commentRepository)
    {
        $comments = $commentRepository->findAll();

        return $this->response($comments);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param PostRepository $postRepository
     * @param $id
     * @return JsonResponse
     * @Route("/post/{id}/add/comment", name="posts_add_comments", methods={"POST"})
     */
    public function getCommentAdd(Request $request, EntityManagerInterface $entityManager,
                                    UserRepository $userRepository, PostRepository $postRepository, $id)
    {
        $user = $userRepository->find($request->get('user_id'));
        $post = $postRepository->find($id);
        if (!$user) {
            $data = [
                'status' => 422,
                'errors' => "User no valid",
            ];
            return $this->response($data, 422);
        }
        if (!$post) {
            $data = [
                'status' => 422,
                'errors' => "Post no valid",
            ];
            return $this->response($data, 422);
        }
        try{
            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('content')){
                throw new \Exception();
            }

            $comment = new Comment();
            $comment->setAuthor($user);
            $comment->setPost($post);
            $comment->setContent($request->get('content'));
            $comment->setPublishedAt(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Comment added successfully",
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