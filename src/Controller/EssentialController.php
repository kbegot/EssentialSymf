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
use App\Repository\EleveRepository;
use App\Repository\ProfesseurRepository;

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
    public function folder(RessourceRepository $ressources, MatiereRepository $matieres, ClasseRepository $classes, EleveRepository $eleves, ProfesseurRepository $professeurs)
    {
        $user = $this->getUser();
        $SelectedRessources = [];
        $userRole = $user->getRoles()[0];

        if ($userRole == "ROLE_ADMIN")
        {
            $SelectedRessources = $ressources->findAll();

        }

        if ($userRole == "ROLE_TEACHER")
        {
            $professeur = $professeurs->findOneByUser($user);
            $lesMatieres = $matieres->findByProfesseur($professeur);
            foreach ($lesMatieres as &$matiere)
            {
                $ressource = $ressources->findOneByMatiere($matiere);
                if (!is_null($ressource))
                {
                    $SelectedRessources[] = $ressource;
                }
            }
        }



        if ($userRole == "ROLE_ELEVE")
        {
 
            $eleve = $eleves->findOneByUser($user);
            $classe = $eleve->getClasse();
            $matieres = $classe->getMatiere();
            foreach ($matieres as &$matiere)
            {
                $ressource = $ressources->findOneByMatiere($matiere);
                if (!is_null($ressource))
                {
                    $SelectedRessources[] = $ressource;
                }
            }
                
        }


        //$SelectedRessources = $ressources->findByMatiere($matieres);
        return $this->render('essential/folder.html.twig',['ressources'=>$SelectedRessources]);
        //return $this->render('essential/folder.html.twig');
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
