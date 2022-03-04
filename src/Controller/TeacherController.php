<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Ressource;
use App\Form\UploadType;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher", name="app_teacher")
     */
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }


    /**
     * @Route("/teacher/upload",name = "upload")
     */
    public function upload(Request $request, SluggerInterface $slugger)
    {
        $ressource = new Ressource();
        $form = $this->createForm(UploadType::class, $ressource);
        $form->handleRequest($request);

        if ($form->issubmitted() && $form->isValid()){
            $ressourcefile = $form->get('upload')->getData();

            if ($ressourcefile){

                // liste d'extension autorisé
                $allowed_extension = ["pdf","jpg","png","txt","docx","ppt","csv","odt","ods","odp","odg"];
                $originalFilename = pathinfo($ressourcefile->getClientOriginalName(), PATHINFO_FILENAME);
                //$file = $upload->getName();
                var_dump($ressourcefile);
                var_dump($originalFilename);
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

                

                //var_dump($file->guessExtension());
                /*
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $upload->setName($fileName);*/
            }

            //return $this->redirectToRoute('home');
        }

        /*if ($form->isSubmitted() && $form->isValdie())
        {
                $file->

        }*/

        return $this->render('teacher/upload.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}
