<?php

namespace App\Controller;

use App\Entity\User;
use App\entity\Ressource;
use App\Repository\UserRepository;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use App\Repository\MatiereRepository;
use App\Repository\RessourceRepository;
use App\Repository\ProfesseurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function home(RessourceRepository $ressources, ClasseRepository $classes, EleveRepository $eleves, ProfesseurRepository $professeurs, UserRepository $users, MatiereRepository $matieres)
    {
        
        $user = $this->getUser();

        if (is_null($user))
        {
            return $this->redirectToRoute('app_login');
        }


        $selectedRessource = [];
        $userRole = $user->getRoles()[0];


        $firstRessources = array();

        $maxRessourceCount = 5;
        

        if ($userRole == "ROLE_TEACHER")
        {
            $professeur = $professeurs->findOneByUser($user);
            $lesMatieres = $matieres->findByProfesseur($professeur);
            $selectedRessource = $ressources->findByMatiere($lesMatieres);

            if (count($selectedRessource) < $maxRessourceCount)
            {
                $firstRessources = $selectedRessource;
            }
            else
            {
                for ($x = 0; $x < $maxRessourceCount; $x++)
            {
                $firstRessources[] = $selectedRessource[$x];
            }
            } 
           
        }

        return $this->render('essential/home.html.twig',['ressources'=>$selectedRessource]);
        
    }


    /**
     * @Route("/folder", name = "folder")
     */
    public function folder(RessourceRepository $ressources, MatiereRepository $matieres, ClasseRepository $classes, EleveRepository $eleves, ProfesseurRepository $professeurs)
    {
        $user = $this->getUser();

        if (is_null($user))
        {
            return $this->redirectToRoute('app_login');
        }

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

        if (is_null($user))
        {
            return $this->redirectToRoute('app_login');
        }

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
