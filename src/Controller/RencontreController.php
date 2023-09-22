<?php

namespace App\Controller;

use App\Entity\Rencontre;
use App\Form\RencontreType;
use App\Repository\RencontreRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RencontreController extends AbstractController
{
    /**
     * @Route("/rencontre", name="rencontre_index")
     */
    public function index(RencontreRepository $repo) : Response
    {
        $repo = $this->getDoctrine()->getRepository(Rencontre::class);

        $rencontres=$repo->findAll();
        $currentDate = new DateTime();

        return $this->render('rencontre/rencontres.html.twig', [
            'rencontre' => $rencontres,
            'currentDate' => $currentDate
            
        ]);
    }

        /**
     * Permet créer une rencontre
     * @IsGranted("ROLE_EDITOR")
     * @Route("/rencontre/new", name= "rencontre_create")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $rencontre = new Rencontre();

        $form = $this->createForm(RencontreType::class, $rencontre);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($rencontre);
            $manager->flush();

            $this->addFlash(
                'success',
                "La rencontre a bien été enregistrée !"
            );
            
            return $this->redirectToRoute('rencontre_show', [
                'id' => $rencontre->getId() 
            ]);
        }

        return $this->render('rencontre/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/rencontre/{id}", name="rencontre_show")
     * @return Response
     */
    public function show(Rencontre $rencontre){
        $aujourdhui = new DateTime();
        $competition = $rencontre->getCompetition()->getNom();

        return $this->render('rencontre/show.html.twig',[
            'rencontre'=>$rencontre,
            'competition'=>$competition,
            'aujourdhui'=>$aujourdhui
        ]);
    }

            /**
     * Permet modifier un rencontre
     *
     * @Route("/rencontre/edit/{id}", name= "rencontre_edit")
     * 
     * @return Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, Rencontre $rencontre)
    { 

        $form = $this->createForm(RencontreType::class, $rencontre);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($rencontre);
            $manager->flush();

            $this->addFlash(
                'success',
                "La rencontre a bien été modifié !",
            );
            
            return $this->redirectToRoute('rencontre_show', [
                'id' => $rencontre->getId() 
            ]);
        }

        return $this->render('rencontre/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

               /**
     * Permet supprimer une rencontre
     *
     * @Route("/rencontre/delete/{id}", name= "rencontre_delete")
     * @IsGranted("ROLE_EDITOR")
     * 
     * @return Response
     */
    public function delete(Rencontre $id, EntityManagerInterface $manager )
    { 
            $manager->remove($id);
            $manager->flush();

            $this->addFlash(
                'success',
                "La rencontre a bien été supprimé !"
            );
            
            return $this->redirectToRoute("rencontre_index");
        
        
    }
}