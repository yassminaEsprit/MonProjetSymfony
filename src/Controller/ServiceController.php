<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'show_service')]
    public function showService(string $name): Response
    {
        // $this->render() permet de rendre un template Twig
        return $this->render('service/showService.html.twig', [
            'name' => $name
        ]);
    }
    #[Route('/go-to-index', name: 'go_to_index')]
public function goToIndex(): Response
{
    // Redirige vers la route nommée 'app_home' (index du HomeController)
    return $this->redirectToRoute('app_home');
}

}
