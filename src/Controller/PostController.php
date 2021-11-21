<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Service\PostServices;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class PostController
 * @package App\Controller
 * @Route("/posts",name="post Controller")
 */
class PostController extends AbstractController
{
    private $postService = null;

    public function __construct(PostServices $postServices)
    {
        $this->postService = $postServices;
    }

    /**
     * @Route("/", name="post")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        var_dump( $posts[0]);
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts
        ]);
    }

    /**
     * @param Request $request
     * @Route("/create",name="create post")
     * @return JsonResponse
     */
    public function createPostAction(Request $request)
    {
        if ($request->getMethod() === "POST") {
            $post = new Post();
            $title = $request->get('title');
            $post->setTitle($title);


            //entity manager
            $en = $this->getDoctrine()->getManager();
            $en->persist($post);
            //to pass changes to DB
            $en->flush();

            //return a response
            return new JsonResponse(array(
                'message' => "Post was created successfully"
            ), 200);
        } else {
            //return error response
            return new JsonResponse(array(
                "error" => "Invalid request method!",
                "code" => "INVALID_REQUEST"
            ), 500);
        }
    }

    /**
     * @param Request $request
     * @param PostRepository $postRepository
     * @param Serializer $serializer
     * @return JsonResponse
     * @Route("/getAll",name="getAllPosts")
     */
    public function getAllAction(Request $request, PostRepository $postRepository, SerializerInterface  $serializer)
    {
        if ($request->getMethod() === "GET") {
            $posts = $postRepository->findAll();
            $posts = $serializer->serialize($posts,'json');
            //var_dump($posts);
            return new JsonResponse(array(
                'posts' => $posts
            ), 200);
        } else {
            //return error response
            return new JsonResponse(array(
                "error" => "Invalid request method!",
                "code" => "INVALID_REQUEST"
            ), 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/all",name="get all posts")
     */

    public function getAllPostsAction (Request $request) : JsonResponse{
        if($request->getMethod() === "GET"){
            //$posts = $this->container->get("posts_service")->getPosts();
            $posts = $this->postService->getPosts();
            return new JsonResponse([
                'posts' => json_encode($posts)
            ],200);
        }else {
            return new JsonResponse([
                'code' => 'INVALID_METHOD_REQUEST',
                "message" => "Check your request method!"
            ],500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/save",name="create new post")
     */
    public function addPost(Request $request){
        if($request->getMethod() === "POST"){
            $result = $this->postService->addPost($request->get("title"));
            if($result === true){
                return new JsonResponse([
                    'code' => 'POST_SAVED',
                    "message" => "Post successfully saved!"
                ],200);
            }else{
                return new JsonResponse([
                    'code' => 'SAVE_ERROR',
                    "message" => $result
                ],503);
            }
        }else{
            return new JsonResponse([
                'code' => 'INVALID_METHOD_REQUEST',
                "message" => "Check your request method!"
            ],500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/delete",name="delete post")
     */
    public function deletePostAction(Request $request){
        if($request->getMethod() === "DELETE"){
            $result = $this->postService->deletePost($request->get('postID'));
            if($request){
                return new JsonResponse([
                    'code' => 'POST_DELETED',
                    "message" => "Post successfully deleted!"
                ],200);
            }else{
                return new JsonResponse([
                    'code' => 'DELETE_ERROR',
                    "message" => $result
                ],503);
            }
        }else{
            return new JsonResponse([
                'code' => 'INVALID_METHOD_REQUEST',
                "message" => "Check your request method!"
            ],500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/get","get postby id")
     */
    public function getPost(Request $request) : JsonResponse{
        if($request->getMethod() === "GET"){
            $result = $this->postService->getPost($request->get("postID"));
            return new JsonResponse([
                'post' => $result
            ],200);
        }else{
            return new JsonResponse([
                'code' => 'INVALID_METHOD_REQUEST',
                "message" => "Check your request method!"
            ],500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/getByTitle",name="get post by title")
     */
    public function getPostByTitleAction(Request $request): JsonResponse{
        if($request->getMethod() === "GET"){
            $result = $this->postService->getPostByTitle($request->get("postID"));
            return new JsonResponse([
                'post' => $result
            ],200);
        }else {
            return new JsonResponse([
                'code' => 'INVALID_METHOD_REQUEST',
                "message" => "Check your request method!"
            ], 500);
        }
    }
}
