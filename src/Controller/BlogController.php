<?php
namespace App\Controller;
use App\Service\Greeting;
use Cassandra\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @var
     */
    private $greeting;
    public function __construct(Greeting $greet)
    {
        $this->greeting = $greet;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        return $this->render('base.html.twig', ['message' => $this->greeting->greet(
            $request->get('name'))]);
    }

    public function home(Request $request)
    {
        return new JsonResponse(['name'=> $request->get('name'),'time'=>'13/02/2021'],200);
    }



}