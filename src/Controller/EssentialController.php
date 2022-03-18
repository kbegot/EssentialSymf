<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\entity\Ressource;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Repository\RessourceRepository;
use App\Repository\MatiereRepository;
use App\Repository\ClasseRepository;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


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
    public function folder(RessourceRepository $ressources, MatiereRepository $matieres, ClasseRepository $classes)
    {
        return $this->render('essential/folder.html.twig',['classes'=>$classes->findAll(), 'ressources'=>$ressources->findAll()]);
    }


    /**
     * @Route("/folder/{id}", name = "fileGet")
     */
    public function fileGet(RessourceRepository $ressources, $id)
    {
        $ressource = $ressources->findOneById($id);
        $file = new File($this->getParameter('upload_directory') . '/' . $ressource->getPath());
        return $this->file($file, $ressource->getName());

    }


    /**
     * @Route("/deniedaccess", name = "deniedaccess")
     */
    public function deniedaccess()
    {
        return $this->render('essential/deniedaccess.html.twig');
    }

    /**
     * @Route("/user", name = "user")
     */
    public function user()
    {
        return $this->render('essential/user.html.twig');
    }


}
