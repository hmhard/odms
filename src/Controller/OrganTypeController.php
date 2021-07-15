<?php

namespace App\Controller;

use App\Entity\OrganType;
use App\Form\OrganTypeType;
use App\Repository\OrganTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/organ-type')]
class OrganTypeController extends AbstractController
{
    #[Route('/', name: 'organ_type_index', methods: ['GET'])]
    public function index(OrganTypeRepository $organTypeRepository): Response
    {
        return $this->render('organ_type/index.html.twig', [
            'organ_types' => $organTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'organ_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $organType = new OrganType();
        $form = $this->createForm(OrganTypeType::class, $organType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organType);
            $entityManager->flush();

            return $this->redirectToRoute('organ_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organ_type/new.html.twig', [
            'organ_type' => $organType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'organ_type_show', methods: ['GET'])]
    public function show(OrganType $organType): Response
    {
        return $this->render('organ_type/show.html.twig', [
            'organ_type' => $organType,
        ]);
    }

    #[Route('/{id}/edit', name: 'organ_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OrganType $organType): Response
    {
        $form = $this->createForm(OrganTypeType::class, $organType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('organ_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organ_type/edit.html.twig', [
            'organ_type' => $organType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'organ_type_delete', methods: ['POST'])]
    public function delete(Request $request, OrganType $organType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($organType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('organ_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
