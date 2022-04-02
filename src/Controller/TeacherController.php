<?php

namespace App\Controller;

use App\Form\UploadType;
use App\Entity\Ressource;
use App\Repository\RessourceRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher", name="teacher_home")
     */
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }


    /**
     * @Route("/teacher/upload",name = "teacher_upload")
     */
    public function upload(Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $ressource = new Ressource();
        $form = $this->createForm(UploadType::class, $ressource);
        $form->handleRequest($request);

        if ($form->issubmitted() && $form->isValid()){
            $ressourcefile = $form->get('upload')->getData();

            if ($ressourcefile){

                // liste d'extension autorisé (finalement désactivé)
                $allowed_extension = [
                    "pdf","jpg","png","txt","docx","xlsx","ppt","csv","odt","ods","odp","odg","mp3","mp4","zip",
                ];

                //nom original du fichier
                $originalFilename = pathinfo($ressourcefile->getClientOriginalName(), PATHINFO_FILENAME);

                $extension = pathinfo($ressourcefile->getClientOriginalName(), PATHINFO_EXTENSION);
                
                // nouveau nom généré a partir du hash
                $fileName = md5(uniqid()).'.'. $extension;

                $ressource->setName($originalFilename);
                $ressource->setPath($fileName);
                $ressource->setExtension($extension);
                $ressource->setDate(new \DateTime('now'));
                
                $ressourcefile->move($this->getParameter('upload_directory'), $fileName);

                $entityManager->persist($ressource);
                $entityManager->flush();
    

            }

            return $this->redirectToRoute('teacher_upload');
        }

        return $this->render('teacher/upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/teacher/removefile/{id}", name = "teacher_removeFile")
     */
    public function RemoveFile(RessourceRepository $ressources, ProfesseurRepository $professeurs, $id)
    {
        $user = $this->getUser();
        $role = $user->getRoles()[0];
        $authorized = false;

        if ($role == 'ROLE_ADMIN')
        {
            $authorized = true;
        }

        if ($role == 'ROLE_TEACHER')
        {
            $professeur = $professeurs->findOneByUser($user);
            $ressource = $ressources->findOneById($id);

            if (is_null($professeur) or is_null($ressource))
            {
                $authorized = false;
            }
            
            else if ($ressource->getMatiere() == $professeur->getMatiere())
            {
                $authorized = true;
            }

        }

        if ($authorized)
        {

            $ressource = $ressources->find($id);
            
            $filename = $this->getParameter('upload_directory') . "/" . $ressource->getPath();
            $ressourcename = $ressource->getName() . "." . $ressource->getExtension();
            
            unlink($filename);
            $ressources->remove($ressource, true);
            
            $this->addFlash('info','la ressource a été supprimée');
        }


        else
        {
            $this->addFlash('error','vous n\'êtes pas autorisé à supprimer cette ressource');
        }

        return $this->redirectToRoute('folder');
    }





}
