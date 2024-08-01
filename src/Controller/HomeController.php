<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class HomeController extends AbstractController
{
    public function __construct(
        private ContainerBagInterface $params,
        private RouterInterface $router
    ) {
    }
    
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

    /**
     *@Route("/myenv", name="app_env")
     */
    public function envManage()
    {
        $appEnv    =   $_ENV['DB_PASS'];
        $appEnv2   =   $_SERVER['DB_USER'];
        dump($appEnv);
        dump($appEnv2);
        return new Response("GET ENV");
    }

    #[Route('/myparameters', name: 'app_parameters')]
    public function parametersManage()
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $adminEmail = $this->getParameter('app.admin_email');
        $appNAme = $this->getParameter('app.name');

        //use this to avoid inject each parameter in each service
        $sender = $this->params->get('app.name');
        
        dump($projectDir);
        dump($adminEmail);
        dump($appNAme);
        dump($sender);
        return new Response("GET ENV");
    }

    #[Route('/myurlparameter/{id<\d+>}/{name}', name: 'app_urlparameters')]
    public function urlParametersManage(int $id,string $name)
    {
        dump($id);
        dump($name);
        return new Response("GET URL PARAM");
    }

    #[Route('/pages', name: 'app_pages')]
    public function allPages()
    {
        $routeCollection = $this->router->getRouteCollection();
        $routes = [];
        foreach ($routeCollection as $routeName => $route) {
            $routes[$routeName] = $route->getPath();
        }
        return $this->render('pages.html.twig', compact('routes'));
    }
}