<?php

namespace App\Controller;

use DateTime;
use App\Entity\Poste;
use App\Entity\Personne;
use App\Form\JoueurType;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JoueurController extends AbstractController
{
    /**
     * @Route("/joueur", name="joueur_index")
     */
    public function index(PersonneRepository $repo) : Response
    {
        $repo = $this->getDoctrine()->getRepository(Personne::class);

        $joueurs=$repo->findAll();

        return $this->render('joueurs/joueur.html.twig', [
            'joueur' => $joueurs
        ]);
    }

    /**
     * Permet créer un joueur
     * @IsGranted("ROLE_EDITOR")
     * @Route("/joueur/new", name= "joueur_create")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $joueur = new Personne();

        $form = $this->createForm(JoueurType::class, $joueur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $poste = $form->get('poste')->getData();
            $joueur -> setPoste($poste);

            $manager->persist($joueur);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le joueur a bien été enregistré !"
            );
            
            return $this->redirectToRoute('joueur_show', [
                'id' => $joueur->getId() 
            ]);
        }

        return $this->render('joueurs/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

        /**
     * Permet modifier un joueur
     *
     * @Route("/joueur/edit/{id}", name= "joueur_edit")
     * 
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, Personne $joueur)
    { 

        $form = $this->createForm(JoueurType::class, $joueur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($joueur);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le joueur a bien été modifié !"
            );
            
            return $this->redirectToRoute('joueur_show', [
                'id' => $joueur->getId() 
            ]);
        }

        return $this->render('joueurs/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }


        /**
     * Permet d'afficher un seul joueur
     *
     * @Route("/joueur/{id}", name="joueur_show")
     * 
     * @return Response
     */
    public function show(Personne $joueur, Personne $id)
    {
        $joueur = $this->getDoctrine()->getRepository(Personne::class)->find($id);

        if (!$joueur) {
            throw $this->createNotFoundException('Joueur introuvable.');
        }

        $birthDate = $joueur->getDateNaiss(); // Assurez-vous d'obtenir la date de naissance du joueur correctement

        // Calculez l'âge
        $now = new DateTime();
        $age = $birthDate->diff($now)->y;
    

        // Récupérez le nom du poste du joueur
        $nomPoste = $joueur->getPoste()->getName();

        return $this->render('joueurs/show.html.twig', [
            'joueur' => $joueur,
            'age' => $age,
            'nomPoste' => $nomPoste
        ]);
    }

           /**
     * Permet supprimer un joueur
     *
     * @Route("/joueur/delete/{id}", name= "joueur_delete")
     * @IsGranted("ROLE_EDITOR")
     * 
     * @return Response
     */
    public function delete(Personne $id, EntityManagerInterface $manager )
    { 
            $manager->remove($id);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le joueur a bien été supprimé !"
            );
            
            return $this->redirectToRoute("joueur_index");
        
        
    }
}
