<?php

namespace App\Controller;

use App\Entity\BloodType;
use App\Entity\Donor;
use App\Entity\OrganType;
use App\Entity\Recipient;
use App\Entity\User;
use App\Entity\UserType;

use App\Repository\RecipientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/recipient')]
class RecipientApi extends AbstractController
{


    #[Route('/create', name: 'recipient_create_api', methods: ['GET', 'POST'])]
    public function create(Request $request, UserPasswordHasherInterface $passwordHasherInterface)
    {
        $em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        /**
         * create new user from submitted data
         */

        try {
        $user = new User();
        $user->setFirstName($data['first_name']);
        $user->setMiddleName($data['middle_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);
        $user->setSex($data['sex']);
        $user->setPhone($data['phone']);
        $user->setPassword($passwordHasherInterface->hashPassword($user, $data['password']));
        $user->setBirthDate(new \DateTime($data['birth_date']));
        $user->setUserType($em->getRepository(UserType::class)->find(UserType::USER_TYPE_CLIENT));
        $this->getDoctrine()->getManager();


        $em->persist($user);

        $recipient = new Recipient();
        $recipient->setOrganNeeded($em->getRepository(OrganType::class)->find(1));
        $recipient->setBloodType($em->getRepository(BloodType::class)->find(1));
        $recipient->setUser($user);

        $em->persist($recipient);
     
     
    
            
            $em->flush();
        } catch (\Throwable $th) {
       
            $response = [
                "success"=>false,
                "message" => $th->getMessage(),
                "data" => $data
            ];
            return $this->json($response, Response::HTTP_BAD_REQUEST);
        }

        $response = [
            "success" => true,
            "message" => "registered Successfully",
            "data" => [
                "user_id" => $user->getId(),
                "recipient_id" => $recipient->getId(),
                "data" => $data['birth_date'],
            ]
        ];
        return $this->json($response, 200);
    }
    #[Route('/show', name: 'recipient_show_api', methods: ['GET', 'POST'])]
    public function show(RecipientRepository $recipientRepository, Request $request)
    {

        try {

        $id = json_decode($request->getContent(), true)['id'];
        
            
        } catch (\Throwable $th) {
           
        }
    
        $response = [
            "success" => true,
            "message" => "fetched",
            "data" =>$recipientRepository->getSingleData(["id"=>$id])
        ];
        return $this->json($response, 200);
    }
    #[Route('/', name: 'recipient_index_api', methods: ['GET', 'POST'])]
    public function index(Request $request, RecipientRepository $recipientRepository)
    {

        $response = [
            "success" => true,
            "message" => "fetched",

            "data" => $recipientRepository->getRecipientList()
        ];
        return $this->json($response, 200);
    }
}
