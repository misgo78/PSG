<?php

namespace App\Controller;

use DateTime;
use App\Repository\RencontreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BilletterieController extends AbstractController
{
    /**
     * @Route("/billetterie", name="billetterie")
     */
    public function index(RencontreRepository $rencontreRepository): Response
    {
        $aujourdhui = new DateTime();
        
        $prochainesRencontres = $rencontreRepository->findProchainesRencontres($aujourdhui, 40);

        return $this->render('billetterie/index.html.twig', [
            'prochainesRencontres' => $prochainesRencontres,
        ]);
    }
}
