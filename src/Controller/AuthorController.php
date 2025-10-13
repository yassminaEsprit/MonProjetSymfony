<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Author;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(EntityManagerInterface $em): Response
    {
        //a repeter 
        //get repority aaibra bvh  inaaytou lil author imteana 
        $authors = $em->getRepository(Author::class)->findAll();
        return $this->render('author/index.html.twig', [
            'authors'=>$authors]);
        

    }
    #[Route('/author/add-statique ', name: 'app_author_add_statique')]
    public function addStatic(EntityManagerInterface $em): Response
    {
       $a=new Author();
       $a->setUsername('yassmina');
       $a->setEmail('yassmina.com');
       $em->persist($a);//les donner bch nabaathhoum fil base de donnee 
    $em->flush();//lancer dans la base de donnee 

        return $this->redirectToRoute('app_author');
    }


/*
    #[Route('/author/show/{name}', name: 'app_author_show')] 
    public function showAuthor(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }

    // Liste des auteurs
    #[Route('/author/list', name: 'app_author_list')]
    public function listAuthors(): Response
    {
        $authors = [
            [
                'id' => 1,
                'picture' => '/images/Victor-Hugo.jpg',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100
            ],
            [
                'id' => 2,
                'picture' => '/images/william-shakespeare.jpg',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200
            ],
            [
                'id' => 3,
                'picture' => '/images/Taha_Hussein.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300
            ]
        ];

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    // Détails d’un auteur par ID
    #[Route('/author/details/{id}', name: 'app_author_details')]
    public function authorDetails(int $id): Response
    {
        $authors = [
            [
                'id' => 1,
                'picture' => '/images/image1.jpg',
                'username' => 'Victor Hugo',
                'email' => 'victor.hugo@gmail.com',
                'nb_books' => 100
            ],
            [
                'id' => 2,
                'picture' => '/images/image2.jpg',
                'username' => 'William Shakespeare',
                'email' => 'william.shakespeare@gmail.com',
                'nb_books' => 200
            ],
            [
                'id' => 3,
                'picture' => '/images/image3.jpg',
                'username' => 'Taha Hussein',
                'email' => 'taha.hussein@gmail.com',
                'nb_books' => 300
            ]
        ];

        // Chercher l’auteur correspondant à l’ID
        $author = null;
        foreach ($authors as $a) {
            if ($a['id'] === $id) {
                $author = $a;
                break;
            }
        }

        // Si auteur non trouvé
        if (!$author) {
            throw $this->createNotFoundException("Auteur introuvable !");
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);

        }
        */

         #[Route('/author/new ', name: 'app_author_new')]
         public function new(EntityManagerInterface $em,Request $Request ): Response
         {
            $a=new Author();
            $form=$this->createForm(AuthorType::class,$a);
            $form->handleRequest($Request);
            if($form->isSubmitted() && $form->isValid()){
                $em->persist($a);//les donner bch nabaathhoum fil base de donnee 
                $em->flush();//lancer dans la base de donnee 
                return $this->redirectToRoute('app_author');
            }
             return $this->render('author/new.html.twig',[
                 'form'=>$form->createView()
             ]);
         }
    #[Route('/author/{id}/edit', name: 'app_author_edit')]
    public function edit( Request $request, EntityManagerInterface $em,int $id ):Response 
    {
        $author = $em->find(Author::class,$id);//haja il zeyda ili fil edit 
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('app_author');

    }
        return $this->render('author/edit.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route('/author/{id}/delete', name: 'app_author_delete')]
     public function delete(EntityManagerInterface $em,int $id):Response 
    {
        $a  = $em->find(Author::class,$id);
        if($a){
            $em->remove($a);
            $em->flush();
        }
        return $this->redirectToRoute('app_author');
    }

} 
