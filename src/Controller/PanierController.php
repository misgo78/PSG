<?php

namespace App\Controller;

use Stripe\Stripe;
use App\StripePaiement;
use App\Entity\Rencontre;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
     /**
     * @Route("/panier", name="panier")
     */
    public function index(Request $request)
    {
        if(!$this->getUser()){
            return $this ->redirectToRoute('app_login');
        }
        $panierIds = $request->getSession()->get('panier', []);
        $quantite = $request->getSession()->get('quantite', []); // Récupérer les quantités depuis la session

        $rencontres = $this->getDoctrine()
            ->getRepository(Rencontre::class)
            ->findBy(['id' => $panierIds]);
        
        return $this->render('panier/index.html.twig', [
            'rencontres' => $rencontres,
            'quantite' => $quantite,
        ]);
    }

    /**
     * @Route("/ajouter-au-panier/{id}", name="ajouter_au_panier")
     */
    public function addToPanier(Request $request, Rencontre $rencontre)
    {
        $panier = $request->getSession()->get('panier', []);
        $quantite = $request->getSession()->get('quantite', []);

        foreach ($panier as $id) {
            $quantites[$id] = $quantites[$id] ?? 1; // Mettre à jour toutes les quantités existantes
        }
        
        if (!in_array($rencontre->getId(), $panier)) {
            $panier[] = $rencontre->getId();
            $quantites[$rencontre->getId()] = 1;
            $request->getSession()->set('panier', $panier);
            $request->getSession()->set('quantite', $quantites);
        }

        $this->addFlash(
            'success',
            sprintf("L'élément a bien été ajouté au panier ! <a href='%s'>Voir le panier</a>", $this->generateUrl('panier'))
        );

        return $this->redirectToRoute('billetterie');
    }

    /**
     * @Route("/supprimer-du-panier/{id}", name="supprimer_du_panier")
     */
    public function supprimerDuPanier($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        // Trouver l'index de l'élément à supprimer dans le panier
        $index = array_search($id, $panier);

        if ($index !== false) {
            // Supprimer l'élément du panier
            unset($panier[$index]);
            // Réindexer les éléments du panier
            $panier = array_values($panier);
            // Mettre à jour le panier en session
            $session->set('panier', $panier);
        }

        $this->addFlash(
            'success',
            "L'élément a bien été supprimé du panier !"
        );

        // Rediriger vers la page du panier
        return $this->redirectToRoute('panier');
    }
}
