<?php

namespace App\Controller;

use App\Repository\AppointmentRepository;
use App\Repository\DonationRepository;
use App\Repository\DonorRepository;
use App\Repository\RecipientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(DonorRepository $donorRepository, AppointmentRepository $appointmentRepository,  DonationRepository $donationRepository, RecipientRepository $recipientRepository): Response
    {
        $donor_count=$donorRepository->getCount();
        $recipient_count=$recipientRepository->getCount();
        $donation_count=$donationRepository->getCount();
        $appointment_count=$appointmentRepository->getCount();
        return $this->render('main/dashboard.html.twig', [
            'controller_name' => 'MainController',
            'donor_count' => $donor_count,
            'recipient_count' => $recipient_count,
            'donation_count' => $donation_count,
            'appointment_count' => $appointment_count,
        ]);
    }
}
