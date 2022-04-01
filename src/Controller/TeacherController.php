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

                // liste d'extension autorisé
                $allowed_extension = [
                    "pdf","jpg","png","txt","docx","xlsx","ppt","csv","odt","ods","odp","odg","mp3","mp4","zip",
                ];
                $originalFilename = pathinfo($ressourcefile->getClientOriginalName(), PATHINFO_FILENAME);
                //$file = $upload->getName();
                //var_dump($ressourcefile->guessExtension());

                if (in_array($ressourcefile->guessExtension(), $allowed_extension)){
                    echo "fichier accepté";
                }

                else{
                    echo "Type de fichier Refusé\nLes fichiers accepté sont :\n";
                    echo '</br>';
                    foreach($allowed_extension as $extension)
                    {
                        echo "$extension </br>";
                    }
                    
                    exit();

                }
                
                $fileName = md5(uniqid()).'.'.$ressourcefile->guessExtension();

                $ressource->setName($originalFilename);
                $ressource->setPath($fileName);
                $ressource->setExtension($ressourcefile->guessExtension());
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
     * @Route("/teacher/removefile", name = "teacher_removeFile")
     */
    public function RemoveFile(RessourceRepository $ressources, ProfesseurRepository $professeurs)
    {
        $user = $this->getUser();

        if ($ressource->getMatiere() == $professeurs->getOneByUser($user)->getMatiere())
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
