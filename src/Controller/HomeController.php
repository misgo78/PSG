<?php

namespace App\Controller;

use DateTime;
use App\Entity\Rencontre;
use App\Repository\RencontreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RencontreRepository $rencontreRepository)
    {
        $aujourdhui = new DateTime();
        
        $dernieresRencontres = $rencontreRepository->findDernieresRencontres($aujourdhui, 3); 
        $prochainesRencontres = $rencontreRepository->findProchainesRencontres($aujourdhui, 3);

        return $this->render('home.html.twig', [
            'dernieresRencontres' => $dernieresRencontres,
            'prochainesRencontres' => $prochainesRencontres,
        ]);


    }
}
