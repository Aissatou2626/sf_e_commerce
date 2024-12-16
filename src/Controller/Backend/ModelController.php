<?php

namespace App\Controller\Backend;

use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/Model', name: 'admin.Model')]
class ModelController extends AbstractController
{
    
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }
    
    #[Route('', name: '.index', methods:['GET'])]
    public function index(ModelRepository $repo): Response
    {
        return $this->render('Backend/Model/index.html.twig', [
            'models' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods:['GET', 'POST'])]
    public function create(Request $request): Response
    {// Je créee un nouvel model
    $model = new Model();
    // Je créee le formulaire et je lui passe l'objet à remplir
    $form = $this->createForm(ModelType::class, $model);

    // Je lui passe la requête afin qu'il puisse récupérer les données
    $form->handleRequest($request);

    
    // Si le formulaire est soumis  et valide, je persiste l'objet en BDD
    if($form->isSubmitted() && $form->isValid()){

        // Je mets en file d'attente l'object à persister
        $this->em->persist($model);

        //J'exécute la file d'attente
        $this->em->flush();
        // Je créee un message flash pour informer à l'utilisateur que le model a bien été créé
        $this->addFlash('success', 'Le model a bien été créée');

        return $this->redirectToRoute('admin.Model.index');
    }
    return $this->render('Backend/Model/create.html.twig', [
        'form' => $form
    ]);
}
    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'] )]
    public function update(?model $model, Request $request){
        if (!$model) {
            $this->addFlash('error', 'Le model demandé n\'existe pas');

            return $this->redirectToRoute('admin.Model.index');
        }
        
        // Pour que le formulaire soit pré-rempli, on procède par ces étapes ci-dessous
        $form = $this->createForm(ModelType ::class, $model);
        $form->handleRequest(request: $request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($model);
            $this->em->flush();

            $this->addFlash('Success', 'Le model a bien été modifié');

            return $this->redirectToRoute('admin.Model.index');
        }

        return $this->render('Backend/Model/update.html.twig', [
            'form' => $form,
        ]);
    } 
    #[Route('/{id}/delete', name:'.delete', methods: ['Post'])]
    public function delete(?Model $model, Request $request): RedirectResponse{
        if (!$model) {
            $this->addFlash('error', 'Le model demandé n\'existe pas.');

            return $this->redirectToRoute('admin.Model.index');
        }
        if ($this->isCsrfTokenValid('delete'. $model->getId(), $request->request->get('token'))) {
            $this->em->remove($model);

            $this->em->flush();

            $this->addFlash('success', 'Le model a bien été supprimé !');
        }else {
            $this->addFlash('error', 'Le jeton CSRF est invalide');
        }
        return $this->redirectToRoute('admin.Model.index');
    }

}
