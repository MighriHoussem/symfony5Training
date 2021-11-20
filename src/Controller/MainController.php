<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        $name= "Sf5 Test";
        $password = '*****';
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'data'=> array('name'=> $name, 'pwd' => $password)
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route ("/framework", name="framework")
     */
    public function frameworkAction (Request $request) : JsonResponse
    {
        $extra = ['version'=> '5.3.4'];
//        foreach ($extra as $ext){
//            print_r('Arg =>'.$ext);
//        }
        if($request->getMethod() === "GET"){
            return new JsonResponse(array(
                'data' => array('name'=>'Symfony5','type' => 'php Framework'),
                'name' => 'Symfony 5.3 Training',
                'extra'=> $extra
            ),200);
        }else {
            return new JsonResponse(array(
                'error' => 'Invalid Method!',
            ), 500);
        }
    }
}
