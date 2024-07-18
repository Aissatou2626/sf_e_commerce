<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', name: 'admin.users')]
class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ){

    }
    
    #[Route('', name: '.index', methods: ['GET'])]
     // Ne pas oublier de renseigner (UserRepository) comme paramètre pour pouvoir récupérer les données et les lire
    public function index(UserRepository $repo): Response
    {
        return $this->render('Backend/user/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }
    // Methode pour modifier les données d'un utilisateur
    #[Route('/{id}/update', name: '.update', methods:['GET', 'POST'])]
    public function update(?User $user, Request $resquest): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');

            return $this->redirectToRoute('admin.users.index');
        }
        
        $form = $this->createForm(UserType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($resquest);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur mis à jour avec succès');

            return $this->redirectToRoute('admin.users.index');
        }
        return $this->render('Backend/user/update.html.twig', [
            'form' => $form,
        ]);
    }
    //Methode pour supprimer un utilisateur
    #[Route('/{id}/delete', name:'.delete', methods:['POST'])]
    public function delete(?User $user, Request $request): RedirectResponse{

        if(!$user){
            $this->addFlash('error', 'Utilisateur Introuvable');

            return $this->redirectToRoute('admin.users.index');
        }

        if ($this->isCsrfTokenValid('delete'. $user->getId(), $request->request->get('token'))) {
            $this->em->remove($user);

            $this->em->flush();


            $this->addFlash('success', 'Votre utilisateur a été supprimé avec succès');

        }
        else{
            $this->addFlash('error', 'Cet utilisateur n\'existe pas');
        }

        return $this->redirectToRoute('admin.users.index');
    }
}
