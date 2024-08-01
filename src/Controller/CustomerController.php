<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function index(Request $request): Response
    {

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class,$customer);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($request->request->all());
        }
        return $this->render('customer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
