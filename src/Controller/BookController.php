<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $author = new Book();
        $form = $this->createForm(BookType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            return $this->redirectToRoute('app_admin_book_new');
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }
}

