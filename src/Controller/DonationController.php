<?php

namespace App\Controller;

use App\Entity\Donation;
use App\Form\DonationType;
use App\Repository\DonationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/donation')]
class DonationController extends AbstractController
{
    #[Route('/', name: 'donation_index', methods: ['GET'])]
    public function index(DonationRepository $donationRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $donationRepository->getData([]);

        $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('donation/index.html.twig', [
            'donations' => $data
        ]);
    }

    #[Route('/new', name: 'donation_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $error = false;
            if ($donation->getDonor()->getStatus() != 0) {
                $error = true;
                $form->addError(new FormError("Donor already donored"));
            }
            if ($donation->getRecipient()->getStatus() != 0) {
                $error = true;
                $form->addError(new FormError("Recipient Already taken organ"));
            }
            if ($error == false) {
                $donor = $donation->getDonor();
                $donor->setStatus(1);
                $recipient = $donation->getRecipient();
                $recipient->setStatus(1);
                $donation->setProcessedBy($this->getUser());
                $donation->setOrgan($donor->getOrgan());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($donation);
                $entityManager->flush();

                return $this->redirectToRoute('donation_index', [], Response::HTTP_SEE_OTHER);
            } else {
            }
        }

        return $this->renderForm('donation/new.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'donation_show', methods: ['GET',"POST"])]
    public function show(Donation $donation, Request $request): Response
    {
        $requestd = $request->request;
        if ($requestd->get('take_action')) {

            if ($requestd->get('approve')) {
                $donation->setStatus(Donation::DONATION_APPROVED);
            }
            if ($requestd->get('cancel')) {
                $donation->setStatus(Donation::DONATION_CANCELLED);
            }
            if ($requestd->get('finish')) {
                $donation->setStatus(Donation::DONATION_FINISHED);
            }
            if ($requestd->get('done')) {
            
                $donation->setStatus(Donation::DONATION_DONE);
            }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Action Done successfully");
            return $this->redirectToRoute("donation_show",['id'=>$donation->getId()]);
        }
        return $this->render('donation/show.html.twig', [
            'donation' => $donation,
        ]);
    }

    #[Route('/{id}/edit', name: 'donation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Donation $donation): Response
    {
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('donation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('donation/edit.html.twig', [
            'donation' => $donation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'donation_delete', methods: ['POST'])]
    public function delete(Request $request, Donation $donation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $donation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($donation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('donation_index', [], Response::HTTP_SEE_OTHER);
    }
}
