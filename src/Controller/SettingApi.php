<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Entity\OrganType;
use App\Entity\User;
use App\Entity\UserType;
use App\Form\DonorType;
use App\Repository\BloodTypeRepository;
use App\Repository\DonorRepository;
use App\Repository\OrganTypeRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/setting')]
class SettingApi extends AbstractController
{



   
    #[Route('/blood-list', name: 'blood_list_api', methods: ['GET', 'POST'])]
    public function bloodList(BloodTypeRepository $bloodTypeRepository, Request $request)
    {

 
        
            $response = [
                "success" => true,
                "message" => "fetched",
                "data" =>$bloodTypeRepository->getBloodList()
            ];
            return $this->json($response, 200);
    }
    #[Route('/organ-list', name: 'organ_list_api', methods: ['GET', 'POST'])]
    public function organList(OrganTypeRepository $organTypeRepository, Request $request)
    {

 
        
            $response = [
                "success" => true,
                "message" => "fetched",
                "data" =>$organTypeRepository->getOrganList()
            ];
            return $this->json($response, 200);
    }
  
}
