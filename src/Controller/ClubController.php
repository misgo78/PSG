<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClubController extends AbstractController
{
    /**
     * @Route("/clubs", name="clubs_index")
     */
    public function index(ClubRepository $repo) : Response
    {
        $clubs = $repo->findAll();

        return $this->render('club/clubs.html.twig', [
            'clubs' => $clubs
        ]);
    }
    
}