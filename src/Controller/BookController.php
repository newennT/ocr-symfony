<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index')]
    public function index(Request $request, BookRepository $repository): Response
    {
        $books = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->createQueryBuilder('b')),
            $request->query->get('page', 1),
            16
        );

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_author_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Book $book, Request $request, EntityManagerInterface $entityManager): Response
    {
        $book ??= new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($book);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_book_show', ['id' => $book->getId()]);
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Book $book): Response 
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}

