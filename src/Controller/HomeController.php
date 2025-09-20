<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//herite de AbstractController
final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return new Response('Bonjour mes étudiants');
       
    }
   

    

/*
    #[Route('/hello', name: 'app_hello')]
    public function hello(): Response
    {
        return new Response("Hello 3A26");
    }

    #[Route('/show', name: 'show')] 
    public function show():Response{
        return new Response(content:"Bienvenu ");

    }
   

     #[Route('/afficher', name: 'afficher')] 
    public function afficher():Response{
        return new render("apropos html.twig");

    }
        */
}