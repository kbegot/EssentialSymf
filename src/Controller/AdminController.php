<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\RessourceRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("admin/userlist", name = "admin_userlist")
     */
    public function userList(UserRepository $users)
    {
        return $this->render('admin/userList.html.twig',['users'=>$users->findAll()]);
    }



    /**
     * @Route("admin/filelist", name ="admin_filelist")
     */
    public function filelist(RessourceRepository $ressources)
    {
        return $this->render('admin/filelist.html.twig',['ressources'=>$ressources->findAll()]);
    }

}