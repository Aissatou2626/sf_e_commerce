<?php

namespace App\Controller\Backend;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        return $this->render('Backend/Gender/index.html.twig', [
            'genders' => $repo->findAll(),
        ]);
    }
    #[Route('/create', name: '.create', methods:['GET', 'POST'] )]
    public function create(Request $request): Response{
        // Je créee un nouvel objet (Gender dans mon cas)
        $gender = new gender();

        // Je créee mon formulaire en lui passant l'objet à instancier
        $form = $this->createForm(GenderType::class, $gender);

        // Je lui passe la request pour qu'il puisse récupérerles données
        $form->handleRequest($request);
        
        // Si le formulaire est soumis  et valide, on persiste l'objet en BDD
        if ($form->isSubmitted() && $form->isValid() ){
             // On met en file d'attente l'objet à persister
             $this->em->persist($gender);

             // On exécute la file d'attente

             $this->em->flush();

            // On créé un message flash pour informer l'utilisateur que la catégorie a bien été créée
            $this->addFlash('succes', 'Le type d\'utilisateur a bien été créer');

            return $this->redirectToRoute('admin.gender.index');

        }
        return $this->render('Backend/Gender/create.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'] )]
    public function update(?gender $gender, Request $request){
        if (!$gender) {
            $this->addFlash('error', 'Le type d\'utilisateur demandé n\'existe pas');

            return $this->redirectToRoute('admin.gender.index');
        }
        
        // Pour que le formulaire soit pré-rempli, on procède par ces étapes ci-dessous
        $form = $this->createForm(GenderType ::class, $gender);
        $form->handleRequest(request: $request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('Success', 'Le genre a bien été modifié');

            return $this->redirectToRoute('admin.gender.index');
        }

        return $this->render('Backend/Gender/update.html.twig', [
            'form' => $form,
        ]);
    } 
    #[Route('/{id}/delete', name:'.delete', methods: ['Post'])]
    public function delete(?Gender $gender, Request $request): RedirectResponse{
        if (!$gender) {
            $this->addFlash('error', 'Le genre demandé n\'existe pas.');

            return $this->redirectToRoute('admin.gender.index');
        }
        if ($this->isCsrfTokenValid('delete'. $gender->getId(), $request->request->get('token'))) {
            $this->em->remove($gender);

            $this->em->flush();

            $this->addFlash('success', 'Le genre a bien été supprimé !');
        }else {
            $this->addFlash('error', 'Le jeton CSRF est invalide');
        }
        return $this->redirectToRoute('admin.gender.index');
    }
}
