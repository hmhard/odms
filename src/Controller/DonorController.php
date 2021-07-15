<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Form\DonorType;
use App\Repository\DonorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/donor')]
class DonorController extends AbstractController
{
    #[Route('/', name: 'donor_index', methods: ['GET'])]
    public function index(DonorRepository $donorRepository, Request $request, PaginatorInterface $paginator): Response
    {


        $queryBuilder = $donorRepository->getData([]);
   
        $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('donor/index.html.twig', [
            'donors' => $data,
        ]);
    }

    #[Route('/new', name: 'donor_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $donor = new Donor();
        $form = $this->createForm(DonorType::class, $donor,);
      
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donor);

            $entityManager->flush();
            $this->addFlash("success","Donor Registered Successfully!!");

            return $this->redirectToRoute('donor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donor/new.html.twig', [
            'donor' => $donor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'donor_show', methods: ['GET'])]
    public function show(Donor $donor): Response
    {
        return $this->render('donor/show.html.twig', [
            'donor' => $donor,
        ]);
    }

    #[Route('/{id}/edit', name: 'donor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Donor $donor): Response
    {
        $form = $this->createForm(DonorType::class, $donor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donor/edit.html.twig', [
            'donor' => $donor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'donor_delete', methods: ['POST'])]
    public function delete(Request $request, Donor $donor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($donor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('donor_index', [], Response::HTTP_SEE_OTHER);
    }
}
