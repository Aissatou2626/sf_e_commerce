<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users', name: 'admin.users')]
class UserController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]
     // Ne pas oublier de renseigner (UserRepository) comme paramètre pour pouvoir récupérer les données et les lire
    public function index(UserRepository $repo): Response
    {
        return $this->render('Backend/user/index.html.twig', [
            'users' =>$repo->findAll(),
        ]);
    }
}
