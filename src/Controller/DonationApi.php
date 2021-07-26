<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\BloodType;
use App\Entity\DonationCenter;
use App\Entity\Donor;
use App\Entity\OrganType;
use App\Entity\User;
use App\Entity\UserType;
use App\Form\DonorType;
use App\Repository\AppointmentRepository;
use App\Repository\DonationCenterRepository;
use App\Repository\DonationRepository;
use App\Repository\DonorRepository;
use App\Repository\RecipientRepository;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/donation')]
class DonationApi extends AbstractController
{





    #[Route('/show', name: 'donation_show_api', methods: ['GET', 'POST'])]
    public function show(DonationRepository $donationRepository,UserRepository $userRepository, DonationCenterRepository $donationCenterRepository, RecipientRepository $recipientRepository, DonorRepository $donorRepository, Request $request)
    {


        try {

            $id = json_decode($request->getContent(), true)['donor_id'];
        } catch (\Throwable $th) {
        }
        $data = [];
        $donation = $donationRepository->getSingleData(["donor_id" => $id]);
        if ($donation) {
            $data['donation'] = $donation;
            $data["donor"] = $donorRepository->getSingleData(["id" => $donation['donor_id']]);
            $data["recipient"] = $recipientRepository->getSingleData(["id" => $donation['donor_id']]);
            $data["donation_center"] = $donationCenterRepository->getSingleData(["id" => $donation['donor_id']]);
            $data["proccessed_by"] = $userRepository->getSingleData(["id" => $donation['user_id']]);
        }

        $response = [
            "success" => true,
            "message" => "fetched",
            "data" => $data
        ];
        return $this->json($response, 200);
    }
}
