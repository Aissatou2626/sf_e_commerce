<?php

namespace App\Controller\Backend;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/gender', name: 'admin.gender')]
class GenderController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }
    
    #[Route('', name: '.index', methods: ['GET'])]
    public function index(GenderRepository $repo): Response
    {
        // Pour le Read du CRUD
        return $this->render('Backend/gender/index.html.twig', [
            'genders' => $repo->findAll(),
        ]);
    }
}
