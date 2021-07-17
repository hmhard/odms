<?php

namespace App\Controller;

use App\Entity\BloodType;
use App\Entity\Donor;
use App\Entity\OrganType;
use App\Entity\Recipient;
use App\Entity\User;
use App\Entity\UserType;
use App\Repository\DonationCenterRepository;
use App\Repository\RecipientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/donation-center')]
class DonationCenterApi extends AbstractController
{


    #[Route('/show', name: 'donation_center_show_api', methods: ['GET', 'POST'])]
    public function show(DonationCenterRepository $donationCenterRepository, Request $request)
    {

        try {

        $id = json_decode($request->getContent(), true)['id'];
        
            
        } catch (\Throwable $th) {
           
        }
    
        $response = [
            "success" => true,
            "message" => "fetched",
            "data" =>$donationCenterRepository->getSingleData(["id"=>$id])
        ];
        return $this->json($response, 200);
    }
    #[Route('/', name: 'donation_center_index_api', methods: ['GET', 'POST'])]
    public function index(Request $request, DonationCenterRepository $donationCenterRepository)
    {

        $response = [
            "success" => true,
            "message" => "fetched",

            "data" => $donationCenterRepository->getDonationCenterList()
        ];
        return $this->json($response, 200);
    }
}
