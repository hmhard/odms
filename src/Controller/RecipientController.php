<?php

namespace App\Controller;

use App\Entity\Recipient;
use App\Form\RecipientType;
use App\Repository\RecipientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

#[Route('/recipient')]
class RecipientController extends AbstractController
{
    #[Route('/', name: 'recipient_index', methods: ['GET'])]
    public function index(RecipientRepository $recipientRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $recipientRepository->getData([]);
   

        $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('recipient/index.html.twig', [
            'recipients' => $data,
        ]);
    }
    #[Route('/new', name: 'recipient_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $recipient = new Recipient();
        $form = $this->createForm(RecipientType::class, $recipient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipient);
            $entityManager->flush();

            return $this->redirectToRoute('recipient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recipient/new.html.twig', [
            'recipient' => $recipient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recipient_show', methods: ['GET'])]
    public function show(Recipient $recipient): Response
    {
        return $this->render('recipient/show.html.twig', [
            'recipient' => $recipient,
        ]);
    }

    #[Route('/{id}/edit', name: 'recipient_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Recipient $recipient): Response
    {
        $form = $this->createForm(RecipientType::class, $recipient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recipient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recipient/edit.html.twig', [
            'recipient' => $recipient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'recipient_delete', methods: ['POST'])]
    public function delete(Request $request, Recipient $recipient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recipient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recipient_index', [], Response::HTTP_SEE_OTHER);
    }
}
