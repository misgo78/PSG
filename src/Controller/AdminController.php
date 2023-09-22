<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    /**
     * Liste les utilisateurs du site
     * 
     * @route("/utilisateurs", name="utilisateurs")
     */
    public function usersList(UsersRepository $users){
        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);
    }

    /**
     * Modifier un utilisateur
     * 
     * @Route("/utilisateur/modifier/{id}", name="modifier_utilisateur")
     */
    public function edtiUser(Users $user, Request $request){
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * Supprimer un utilisateur
     *
     * @Route("/utilisateur/supprimer/{id}", name="supprimer_utilisateur")
     */

    public function deleteUser(Users $user, Request $request): Response
    {

        // Supprimez l'utilisateur
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        // Ajoutez un message flash pour confirmer la suppression
        $this->addFlash('message', 'Utilisateur supprimé avec succès');

        // Redirigez vers la liste des utilisateurs (ou une autre page appropriée)
        return $this->redirectToRoute('admin_utilisateurs');
    }

}
