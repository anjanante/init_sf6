<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Services\MyHelper;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private LoggerInterface $logger
    ) {
    }

    #[Route('/customer', name: 'app_customer')]
    public function index(Request $request, MyHelper $oHelper): Response
    {

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class,$customer);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $customer = $form->getData();
            $em->persist($customer);
            $em->flush();
            $this->logger->log('info', 'Add new User ['.$customer->getName().']');
            return $this->redirectToRoute('app_customer');
        }
        return $this->render('customer/index.html.twig', [
            'form' => $form->createView(),
            'sDateNow' => $oHelper->getDateNow()->format('d-m-Y')
        ]);
    }
}
