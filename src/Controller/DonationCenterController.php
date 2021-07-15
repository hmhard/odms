<?php

namespace App\Controller;

use App\Entity\DonationCenter;
use App\Form\DonationCenterType;
use App\Repository\DonationCenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

#[Route('/donation-center')]
class DonationCenterController extends AbstractController
{
    #[Route('/', name: 'donation_center_index', methods: ['GET'])]
    public function index(DonationCenterRepository $donationCenterRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $donationCenterRepository->getData([]);
   

        $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('donation_center/index.html.twig', [
            'donation_centers' => $data,
        ]);
    }

    #[Route('/new', name: 'donation_center_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $donationCenter = new DonationCenter();
        $form = $this->createForm(DonationCenterType::class, $donationCenter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($donationCenter);
            $entityManager->flush();

            $this->addFlash("success","Registered Successfully");

            return $this->redirectToRoute('donation_center_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation_center/new.html.twig', [
            'donation_center' => $donationCenter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'donation_center_show', methods: ['GET'])]
    public function show(DonationCenter $donationCenter): Response
    {
        return $this->render('donation_center/show.html.twig', [
            'donation_center' => $donationCenter,
        ]);
    }

    #[Route('/{id}/edit', name: 'donation_center_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DonationCenter $donationCenter): Response
    {
        $form = $this->createForm(DonationCenterType::class, $donationCenter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_center_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation_center/edit.html.twig', [
            'donation_center' => $donationCenter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'donation_center_delete', methods: ['POST'])]
    public function delete(Request $request, DonationCenter $donationCenter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$donationCenter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($donationCenter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('donation_center_index', [], Response::HTTP_SEE_OTHER);
    }
}
