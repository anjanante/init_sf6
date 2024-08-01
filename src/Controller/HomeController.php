<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/redirect', name: 'app_redirect')]
    public function redirectTo(): RedirectResponse
    {
        return $this->redirectToRoute('app_goodbye');
    }

    #[Route('/goodbye', name: 'app_goodbye')]
    public function goodbye(): Response
    {
        return new Response("BYE BYE From goodbye action");
    }

    #[Route('/mylinkedin', name: 'app_linkedin')]
    public function myLinkedin(): RedirectResponse
    {
        return $this->redirect('https://www.linkedin.com/in/nante-rajaona/');
    }

    #[Route('/myrequest', name: 'app_request')]
    public function requestManage(Request $request)
    {
        $all    =   $request->query->all();
        $get    =   $request->query->get('my-key');
        $post   =   $request->request->get('my-key');
        dump($get);
        dump($all);
        return new Response($request->getMethod());
    }
}