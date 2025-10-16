<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $books = $em->getRepository(Book::class)->findAll();

        $countPublished = $em->getRepository(Book::class)->count(['published' => true]);
        $countUnPublished = $em->getRepository(Book::class)->count(['published' => false]);

        return $this->render('book/index.html.twig', [
            'books' => $books, 
            'countPublished' => $countPublished,
            'countUnPublished' => $countUnPublished,
        ]);
    }

    #[Route('/book/new', name: 'app_book_new')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $book = new Book();
        $book->setPublished(true);

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/book/{id}/edit', name: 'app_book_edit')]
    public function edit(EntityManagerInterface $em, Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush(); // flush suffit car $book est déjà géré par Doctrine

            return $this->redirectToRoute('app_book_index');
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }

    #[Route('/book/{id}/delete', name: 'app_book_delete')]
    public function delete(EntityManagerInterface $em, Book $book): Response
    {
        $em->remove($book);
        $em->flush();

        return $this->redirectToRoute('app_book_index');
    }

    #[Route('/book/{id}/show', name: 'app_book_show')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
    #[Route('/book/{id}/readers', name: 'app_book_readers')]
public function readers(EntityManagerInterface $em, Book $book): Response
{
    $readers = $book->getReaders();

    return $this->render('book/readers.html.twig', [
        'book' => $book,
        'readers' => $readers
    ]);
}

}
