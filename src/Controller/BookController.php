<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use App\Form\BookType;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(EntityManagerInterface $em): Response
    {
        $books = $em->getRepository(Book::class)->findAll();
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/new', name: 'app_book_new')]
    function new(EntityManagerInterface $em, Request $request  ): Response
    {
    

    $book=new Book();
    $book->setPublished (true );
    $form=$this->createForm(BookType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()){
        $book=$form->getData();
        $em->persist($book);
        $em->flush();
        return $this->redirectToRoute('app_book');
    }
    return $this->render('book/new.html.twig',[
        'form'=>$form->createView()
    ]);
}
} 