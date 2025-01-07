<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Editor;
use App\Form\EditorType;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/editor')]
class EditorController extends AbstractController
{
    #[Route('', name: 'app_admin_editor_index')]
    public function index(): Response
    {
        return $this->render('editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }

    #[Route('/new', name: 'app_admin_editor_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $author = new Editor();
        $form = $this->createForm(EditorType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            return $this->redirectToRoute('app_admin_editor_new');
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form,
        ]);
    }
}
