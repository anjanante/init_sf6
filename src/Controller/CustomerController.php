<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine
    ) {
    }

    #[Route('/customer', name: 'app_customer')]
    public function index(Request $request): Response
    {

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class,$customer);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $customer = $form->getData();
            dump($customer);
            $em->persist($customer);
            $em->flush();
            return $this->redirectToRoute('app_customer');
        }
        return $this->render('customer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
