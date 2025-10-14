<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // ← Manquait !
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // ← Corrigé : c’est "Annotation\Route", pas "Attribute\Route"

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(EntityManagerInterface $em): Response
    {
        $books = $em->getRepository(Book::class)->findAll();
        $countPublished = $em->getRepository(Book::class)->count(['published'=>true]);
        $countUnPublished =$em ->getRepository(Book::class)->count(['published'=>false]);
        return $this->render('book/index.html.twig', [
            'book' =>$books,
            'countPublished' =>$countPublished,
            'countUnPublished'=>$countUnPublished,

        ]);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'books' => $books, // ← Tu veux sûrement afficher les livres dans la vue
        ]);
    }

    #[Route('/book/new', name: 'app_book_new')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $book = new Book();
        $book->setPublished(true);

        // Il faut passer $book à createForm()
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('app_book');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route ('/book/{id}/delete ', name:'app_book_delete')]
    public function delete(EntityManagerInterface $em, Book $book): Response
    {
        $book = $em->getRepository(Book::class)->find($id);
        if ($book) {
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('app_book');

    }
    #[Route('/book/{id}/show',name :'app_book_show')] 
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}
