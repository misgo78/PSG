<?php

namespace App\Controller;

use DateTime;
use App\Entity\Order;
use App\Form\OrderType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/order/verify", name="order_index")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(OrderType::class,null,[
            'user'=>$this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $datetime = new DateTime('now');
            $reference = $datetime->format('dmY').'-'.uniqid();
            $order = new Order();
            $order -> setReference($reference);
            $order -> setUser($this->getUser());
            $order -> setCreatedAt($datetime);
            $order->setIsPaid(0);
            $this->em->persist($order);
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * @Route("/order/verify", name="order_prepare", methods: ['GET'])
    //  */
    // public function prepareOrder(): Response{
    //     return $this->render('order/recap.html.twig');
    // }
}
