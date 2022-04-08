<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Classe;
use App\Entity\Matiere;
use App\Entity\Professeur;
use App\Form\CreationClasseType;
use App\Form\CreationMatiereType;
use App\Repository\UserRepository;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use App\Repository\MatiereRepository;
use App\Repository\RessourceRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(UserRepository $users, EleveRepository $eleves, ClasseRepository $classes, ProfesseurRepository $professeurs, RessourceRepository $ressources): Response
    {
        $allUsers = $users->findAll();
        $allClasses = $classes->findAll();
        $firstUsers = array();
        $firstClasses = array();

        $maxUserCount = 10;
        $maxClassesCount = 5;

        if (count($allUsers) < $maxUserCount)
        {
            $firstUsers = $allUsers;
        }

        else{

            for ($i = 0; $i < $maxUserCount; $i++)
            {
                $firstUsers[] = $allUsers[$i];
            }
        }


        if (count($allClasses) < $maxClassesCount)
        {
            $firstClasses = $allClasses;
        }

        else
        {
            for ($i = 0; $i < $maxClassesCount ; $i++)
            {
                $firstClasses[] = $allClasses[$i];
            }
        }

        
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController','users'=>$firstUsers,'classes'=>$firstClasses, 'eleves'=>$eleves->findAll(), 'professeurs'=>$professeurs->findAll(),'ressources'=>$ressources->findAll()
        ]);
    }

    /**
     * @Route("admin/userlist", name = "admin_userlist")
     */
    public function userList(UserRepository $users, ClasseRepository $classes, MatiereRepository $matieres)
    {
        return $this->render('admin/userList.html.twig',['users'=>$users->findAll(),'classes'=>$classes->findAll(),'matieres'=>$matieres->findAll()]);
    }

    /**
     * @Route("admin/userlist/edit/{userid}/{role}/{classeid_matiereid}", name = "admin_useredit")
     */
    public function userEdit(UserRepository $users, EleveRepository $eleves, ClasseRepository $classes, ProfesseurRepository $professeurs, Matiererepository $matieres ,$userid, $role, $classeid_matiereid, EntityManagerInterface $entityManager)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $user = $users->find($userid);

        if ($currentUser == $user)
        {
            $this->addFlash('erreur','Vous ne pouvez pas modifier votre propre rôle');
            return $this->redirectToRoute('admin_userlist');
        }


        if ($role == 'ROLE_ELEVE')
        {
            $classeid = $classeid_matiereid;

            if (!$classes->find($classeid))
            {
                $this->addFlash('erreur','La classe spécifié est introuvable');
                return $this->redirectToRoute('admin_userlist');
            }

            if ($eleves->findOneByUser($userid))
            {
                $eleve = $eleves->findOneByUser($user);
            }

            else
            {
                $eleve = new eleve();
                $eleve->setUser($user);
            }
            
            
            if ($professeurs->findOneByUser($user))
            {
                if ($matieres->findOneByProfesseur($professeurs->findOneByUser($user)))
                {
                    $professeur = $professeurs->findOneByUser($user);
                    $matiere = $matieres->findOneByProfesseur($professeur);
                    $matiere->RemoveProfesseur();
                    $entityManager->persist($matiere);
                }
                $entityManager->remove($professeurs->findOneByUser($user));
            }

            $eleve->setClasse($classes->find($classeid));

            $entityManager->persist($eleve);

            $user->setRoles([$role]);
            $entityManager->persist($user);
            $entityManager->flush();


        }

        else if ($role == 'ROLE_TEACHER')
        {
            $matiereid = $classeid_matiereid;
            
            if ($professeurs->findOneByUser($userid))
            {
                $professeur = $professeurs->findOneByUser($user);
                
            }
            
            else
            {
                $professeur = new Professeur();
                $professeur->setUser($user);
                //$professeur->addMatiere($matieres->find($matiereid));
            }
            
            $matiere = $matieres->findOneById($matiereid);
            $matiere->setProfesseur($professeur);

            if ($eleves->findOneByUser($user))
            {
                $entityManager->remove($eleves->findOneByUser($user));
            }

            $user->setRoles([$role]);
            $entityManager->persist($professeur);
            $entityManager->persist($matiere);
            $entityManager->flush();


        }

        else if ($role == 'ROLE_ADMIN')
        {
            $user->setRoles([$role]);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        else
        {
            $this->addFlash('erreur','Le rôle spécifié n\'existe pas');
            return $this->redirectToRoute('admin_userlist');
        }

        $this->addFlash('info','L\'utilisateur a bien été modifié');
        return $this->redirectToRoute('admin_userlist');

    }

    /**
     * @Route("admin/userlist/delete/{id}", name = "admin_userdelete")
     */
    public function userDelete(userRepository $users, EleveRepository $eleves, ProfesseurRepository $professeurs, $id)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $user = $users->find($id);

        if ($currentUser == $user)
        {
            $this->addFlash('erreur','Vous ne pouvez pas supprimer votre propre rôle');
            return $this->redirectToRoute('admin_userlist');
        }
        
        $role = $user->getRoles()[0];
        $entityManager = $this->getDoctrine()->getManager();

        
        if ($role == 'ROLE_ADMIN')
        {
            
        }
        
        if ($role == 'ROLE_TEACHER')
        {
            $professeur = $professeurs->findOneByUser($user);
            $entityManager->remove($professeur);
        }
        
        
        if ($role == 'ROLE_ELEVE')
        {
            $eleve = $eleves->findOneByUser($id);
            $entityManager->remove($eleve);
        }
        
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_userlist');
    }


    /**
     * @Route("admin/filelist", name ="admin_filelist")
     */
    public function filelist(RessourceRepository $ressources, $deletedid=null)
    {
        {
            return $this->render('admin/filelist.html.twig',['ressources'=>$ressources->findAll()]);
        }
    }

    /**
     * @Route("admin/filelist/remove/{id}", name = "admin_filelist_remove")
     */
    public function filelistremove($id,RessourceRepository $ressources)
    {
        $ressource = $ressources->find($id);

        $filename = $this->getParameter('upload_directory') . "/" . $ressource->getPath();
        $ressourcename = $ressource->getName() . "." . $ressource->getExtension();

        unlink($filename);
        $ressources->remove($ressource, true);
        
        $this->addFlash('info','La Ressource a bien été supprimée');

        return $this->redirectToRoute('admin_filelist');
        
    

    }

    /**
     * @Route("admin/fileedit/{id}", name = "admin_filelist_edit")
     */
    public function fileEdit(RessourceRepository $ressources)
    {
        $ressource = $ressources->find($id);

    }


    /**
     * @Route("admin/classelist", name = "admin_classelist")
     */
    public function classelist(ClasseRepository $classes, EleveRepository $eleves, MatiereRepository $matieres)
    {
        
        return $this->render('admin/classelist.html.twig',['eleves'=>$eleves->findAll(),'classes'=>$classes->findAll(),'matieres'=>$matieres->findAll()]);
    }

    /**
     * @Route("admin/classeedit/{id}/{libelle}", name = "admin_classe_edit")
     */
    public function classeEdit(ClasseRepository $classes, $id,$libelle)
    {
        /*$entityManager = $this->getDoctrine()->getManager();
        $classe = $classes->find($id);
        $classe->setLibelle($libelle);
        $entityManager->persist($classe);
        $entityManager->flush();

        $this->redirectToRoute('admin_classe_edit');
        */
        $this->redirectToRoute('admin_classe_edit');
    }


    /**
     * @route("admin/matierelist", name = "admin_matierelist")
     */
    public function matierelist(RessourceRepository $matieres)
    {
        return $this->render('admin/matiere.html.twig',['ressources'=>$matieres->findAll()]);
    }

    /**
     *@Route("/admin/classecreate", name="admin_classecreate")
     */
    public function creationClasse(Request $request, EntityManagerInterface $entityManager): Response 
    {

        $classe = new Classe();
        $form = $this->createForm(CreationClasseType::class, $classe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($classe);
            $entityManager->flush();
            $this->addFlash('info','La Classe a bien été créée');
        }


        return $this->render('admin/classecreate.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     *@Route("/admin/matierecreate", name="admin_matierecreate")
     */
    public function creationMatiere(Request $request, EntityManagerInterface $entityManager): Response 
    {

        $matiere = new Matiere();
        $form = $this->createForm(CreationMatiereType::class, $matiere);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager->persist($matiere);
            $entityManager->flush();
            $this->addFlash('info','La Matière a bien été créée');
        }


        return $this->render('admin/matierecreate.html.twig',[
            'form' => $form->createView()
        ]);
    }



}