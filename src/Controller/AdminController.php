<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\ClasseRepository;
use App\Repository\MatiereRepository;
use App\Repository\RessourceRepository;
use App\Repository\EleveRepository;
use App\Entity\Eleve;
use APP\Entity\Professeur;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(UserRepository $users): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController','users'=>$users->findAll()
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
    public function userEdit(UserRepository $users, EleveRepository $eleves, ClasseRepository $classes, Matiererepository $matieres ,$userid, $role,$classeid_matiereid, EntityManagerInterface $entityManager)
    {

        if ($role == 'ROLE_ELEVE')
        {
            $classeid = $classeid_matiereid;

            if (!$classes->find($classeid))
            {
                return $this->redirectToRoute('admin_userlist');
            }

            if ($eleves->findByUser($userid))
            {

                echo "L'eleve existe déjà";
                return $this->render('admin/userList.html.twig',['users'=>$users->findAll(),'classes'=>$classes->findAll(),'matieres'=>$matieres->findAll(),'message'=>'Erreur, L\'élève existe déjà']);



            }
                $eleve = new eleve();
                $eleve->setUser($users->find($userid));
            $eleve->setClasse($classes->find($classeid));
            $entityManager->persist($eleve);
            $entityManager->flush();


        }

        if ($role == 'ROLE_TEACHER')
        {
            $matiereid = $classeid_matiereid;

            /*if (!$matieres->find($matiereid))
            {
                return $this->redirectToRoute('admin_userlist');
            }*/

            $teacher = new Professeur();
            $teacher->setUser($users->find($userid));
            //$teacher->setMatiere($matieres->find($matiereid));
            $entityManager->persist($teacher);
            $entityManager->flush();


        }

        if ($role == 'ROLE_ADMIN')
        {

        }

        else
        {
            return $this->redirectToRoute('admin_userlist');
        }




        $user = $users->find($userid);
        $user->setRoles([$role]);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_userlist');

    }

    /**
     * @Route("admin/userlist/delete/{id}", name = "admin_userdelete")
     */
    public function userDelete(userRepository $users, $id)
    {
        $user = $users->find($id);
        $users->remove($user, true);
        return $this->redirectToRoute('admin_filelist');
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
    public function classelist(ClasseRepository $classes)
    {
        return $this->render('admin/classelist.html.twig',['ressources'=>$classes->findAll()]);
    }



    /**
     * @route("admin/matierelist", name = "admin_matierelist")
     */
    public function matierelist(RessourceRepository $matieres)
    {
        return $this->render('admin/matiere.html.twig',['ressources'=>$matieres->findAll()]);
    }





}