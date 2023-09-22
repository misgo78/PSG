<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\StripePayment;
use Stripe\StripeClient;
use App\Entity\Rencontre;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaymentController extends AbstractController
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function showPaymentPage(Request $request)
    {
        // Configure Stripe avec votre clé secrète
        $stripeSecretKey = "sk_test_51NnGSHKcY8OEvdclIpV7M4vIG1dpOP5qe2w84xHWv8ZdQRFYh1imFTnfGtjO6WndHxwERNkC7kDZ4ohzZxlB1JMM00BZMIFTiI";
        Stripe::setApiKey($stripeSecretKey);

        $panierIds = $request->getSession()->get('panier', []);
        $quantite = $request->getSession()->get('quantite', []); // Récupérer les quantités depuis la session
        var_dump($panierIds);
        $rencontres = $this->getDoctrine()
            ->getRepository(Rencontre::class)
            ->findBy(['id' => $panierIds]);

        
        // Créez une session Stripe
        $stripe = new StripeClient('sk_test_51NnGSHKcY8OEvdclIpV7M4vIG1dpOP5qe2w84xHWv8ZdQRFYh1imFTnfGtjO6WndHxwERNkC7kDZ4ohzZxlB1JMM00BZMIFTiI');

        $line_items_array = [];
        foreach ($rencontres as $rencontre) {
        $quantiteRencontre = $quantite[$rencontre->getId()];
        $line_items_array[] = [
            'price_data' => [
            'currency' => 'eur', 
            'unit_amount' => $rencontre->getPrix() * 100,
            'product_data' => [
                'name' => $rencontre->getDomicile(),
            ],
            ],
            'quantity' => $quantiteRencontre,
        ];
        }
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $line_items_array,
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/success',
        ]);
            // Redirigez l'utilisateur vers la page de paiement Stripe
        return $this->redirect($checkout_session->url);
    }

    public function successAction(): Response
    {
        // Gérer la logique de réussite du paiement ici
        return $this->render('payment/success.html.twig');
    }

    public function cancelAction(): Response
    {
        // Gérer la logique d'annulation du paiement ici
        return $this->render('payment/cancel.html.twig');
    }
}
