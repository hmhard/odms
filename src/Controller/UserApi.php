<?php

namespace App\Controller;

use App\Entity\BloodType;
use App\Entity\Donor;
use App\Entity\OrganType;
use App\Entity\Recipient;
use App\Entity\User;
use App\Entity\UserType;
use App\Form\DonorType;
use App\Repository\DonorRepository;
use App\Repository\RecipientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserApi extends AbstractController
{



    #[Route('/login', name: 'user_login_api', methods: ['GET', 'POST'])]
    public function login(Request $request, UserPasswordHasherInterface $passwordHasherInterface)
    {
        $em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);
        $user = $em->getRepository(User::class)->findOneBy(["email" => $data['email']]);
        if (!$user) {
            return   $this->json(["success" => false, "message" => "Access Denied"], Response::HTTP_FORBIDDEN);
        }
        $valid_user = $passwordHasherInterface->isPasswordValid($user, $data['password']);
        if (!$valid_user) {
            return     $this->json(["success" => false, "message" => "Access Denied"], Response::HTTP_FORBIDDEN);
        }


        $response = [
            "success" => true,
            "message" => "Authenticated Successfully",
            "data" => [
                "user_id" => $user->getId(),
                "first_name" => $user->getFirstName(),
                "middle_name" => $user->getMiddleName(),

            ]
        ];
        return $this->json($response, 200);
    }
    #[Route('/create', name: 'user_create_api', methods: ['GET', 'POST'])]
    public function create(Request $request, UserPasswordHasherInterface $passwordHasherInterface)
    {
        $em = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setFirstName($data['first_name']);
        $user->setMiddleName($data['middle_name']);
        $user->setLastName($data['last_name']);
        $user->setEmail($data['email']);
        $user->setSex($data['sex']);
        $user->setPhone($data['phone']);
        $user->setPassword($passwordHasherInterface->hashPassword($user, $data['password']));
        $user->setBirthDate(new \DateTime());
        $user->setUserType($em->getRepository(UserType::class)->find(1));
        $this->getDoctrine()->getManager();


        $em->persist($user);

        $recipient = new Recipient();
        $recipient->setOrganNeeded($em->getRepository(OrganType::class)->find(1));
        $recipient->setBloodType($em->getRepository(BloodType::class)->find(1));
        $recipient->setUser($user);

        $em->persist($recipient);
        $em->flush();

        $response = [
            "success" => true,
            "message" => "registered Successfully",
            "data" => [
                "user_id" => $user->getId(),
                "user_id" => $recipient->getId(),
            ]
        ];
        return $this->json($response, 200);
    }
    #[Route('/{id}', name: 'user_show_api', methods: ['GET', 'POST'])]
    public function show(User $user, Request $request)
    {

        $response = [
            "success" => true,
            "message" => "fetched",
            "data" => [
                "user_id" => $user->getId(),

                "first_name" => $user->getFirstName(),
                "middle_name" => $user->getMiddleName(),

            ]
        ];
        return $this->json($response, 200);
    }
    #[Route('/', name: 'user_index_api', methods: ['GET', 'POST'])]
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
