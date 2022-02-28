<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function upload(Request $request)
    {
        $upload = new Ressource();
        $form = $this->createForm(UploadType::class, $upload);

        $form->handleRequest($request);
        if ($form->issubmitted() && $form->isValid()){
            $file = $upload->getName();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $upload->setName($fileName);

            return $this->redirectToRoute('home');
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
