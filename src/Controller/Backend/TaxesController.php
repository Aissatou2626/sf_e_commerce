<?php

namespace App\Controller\Backend;

use App\Entity\Taxes;
use App\Form\TaxesType;
use App\Repository\TaxesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/Taxes', name: 'admin.Taxes')]
class TaxesController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    #[Route('', name: '.index', methods: ['GET'])]
    public function index(TaxesRepository $repo): Response
    {
        return $this->render('Backend/Taxes/index.html.twig', [
            'Taxes' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $taxe = new Taxes();
        $form = $this->createForm(TaxesType::class, $taxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($taxe);
            $em->flush();

            return $this->redirectToRoute('admin.Taxes.index', []);
        }
        return $this->render('Backend/Taxes/create.html.twig', [
            'Taxes' => $taxe,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Taxes $taxe, Request $request): Response
    {
        if (!$taxe) {
            $this->addFlash('error', 'La taxe demandée n\'existe pas!');
            return $this->redirectToRoute('admin.Taxes.index');
        }
        // Pour que le formulaire soit pré-rempli, on procède par ces étapes ci-dessous
        $form = $this->createForm(TaxesType::class, $taxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $this->em->persist($taxe);
           $this->em->flush();

           $this->addFlash('success', 'La taxe a bien été modifiée !');

           return $this->redirectToRoute('admin.Taxes.index');
        }

        return $this->render('Backend/Taxes/update.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Taxes $taxe, Request $request): Response
    {
        if (!$taxe) {
            $this->addFlash('error', 'La taxe demandée n\'existe pas!');

            return $this->redirectToRoute('admin.Taxes.index');
        }  
        
        if ($this->isCsrfTokenValid('delete'. $taxe->getId(), $request->request->get('token'))) {
            $this->em->remove($taxe);

            $this->em->flush();

            $this->addFlash('success', 'La taxe a bien été supprimée !');
        }else {
            $this->addFlash('error', 'Le jeton CSRF est invalide');
        }
        return $this->redirectToRoute('admin.Taxes.index');
    }
    
}
