<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Repository\RessourceRepository;


class EssentialController extends AbstractController
{
    /**
     * @Route("/essential", name="essential")
     */
    public function index(): Response
    {
        return $this->render('essential/index.html.twig', [
            'controller_name' => 'EssentialController',
        ]);
    }
    
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('essential/home.html.twig');
    }


    /**
    * @route("/testauth", name = "test")
    */
    public function testauth()
    {
        $user = $this->getUser();

        if ($user)
        {
            return $this->render('essential/test.html.twig',['user'=>$user]);
        }

        else
        {
            return $this->redirectToRoute('app_login');
        }

    }

    /**
     * @Route("/folder", name = "folder")
     */
    public function folder(RessourceRepository $ressources)
    {
        return $this->render('essential/folder.html.twig',['ressources'=>$ressources->findAll()]);
    }




}
