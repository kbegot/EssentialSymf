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
        $SelectedMatiere = [];
        $userRole = $user->getRoles()[0];

        if ($userRole == "ROLE_ADMIN")
        {
            $selectedMatiere = $matieres->findAll();

        }

        if ($userRole == "ROLE_TEACHER")
        {
            $professeur = $professeurs->findOneByUser($user);
            $selectedMatiere = $matieres->findByProfesseur($professeur)[0];
            dump($SelectedMatiere);

        }



        if ($userRole == "ROLE_ELEVE")
        {
 
            $eleve = $eleves->findOneByUser($user);
            $classe = $eleve->getClasse();
            $selectedMatiere = $classe->getMatiere();
        
        }



        return $this->render('essential/folder.html.twig',['matieres'=>$selectedMatiere]);

    }

    /**
     * @Route("/folder/{matiereid}", name = "folder_matiere")
     */
    public function folderMatiere(RessourceRepository $ressources, MatiereRepository $matieres, ClasseRepository $classes, EleveRepository $eleves, ProfesseurRepository $professeurs, $matiereid)
    {
        $user = $this->getUser();
        $SelectedRessources = [];
        $userRole = $user->getRoles()[0];
        $selectedMatiere = $matieres->findOneById($matiereid);
        $SelectedRessources=  $ressources->findByMatiere($selectedMatiere); 

        if ($userRole == "ROLE_ADMIN")
        {



        }

        if ($userRole == "ROLE_TEACHER")
        {

            $SelectedRessources=  $ressources->findByMatiere($selectedMatiere);

            $professeur = $professeurs->findOneByUser($user);
            $lesMatieres = $matieres->findByProfesseur($professeur);
            if ($lesMatieres[0] != $selectedMatiere)
            {
                $this->addFlash('error','Vous n\'navez pas accès à cette matière');
                return $this->redirectToRoute('folder');
            }

            /*foreach ($lesMatieres as &$matiere)
            {
                $ressource = $ressources->findOneByMatiere($matiere);
                if (!is_null($ressource))
                {
                    $SelectedRessources[] = $ressource;
                }
            }*/
        }



        if ($userRole == "ROLE_ELEVE")
        {
 
            $eleve = $eleves->findOneByUser($user);
            $classe = $eleve->getClasse();
            $lesMatieres = $classe->getMatiere();
            
            if ($lesMatieres[0] != $selectedMatiere)
            {
                $this->addFlash('error','Vous n\'navez pas accès à cette matière');
                return $this->redirectToRoute('folder');
            }



            /*foreach ($matieres as &$matiere)
            {
                $ressource = $ressources->findOneByMatiere($matiere);
                if (!is_null($ressource))
                {
                    $SelectedRessources[] = $ressource;
                }
            }*/
                
        }


        return $this->render('essential/files.html.twig',['ressources'=>$SelectedRessources]);

    }





    /**
     * @Route("/folderGet/{id}", name = "fileGet")
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
