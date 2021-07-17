<?php

namespace App\Controller;

use App\Entity\Donor;
use App\Entity\OrganType;
use App\Entity\User;
use App\Entity\UserType;
use App\Form\DonorType;
use App\Repository\DonorRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/donor')]
class DonorApi extends AbstractController
{



    #[Route('/create', name: 'donor_create_api', methods: ['GET', 'POST'])]
    public function create(Request $request, UserPasswordHasherInterface $passwordHasherInterface)
    {
        $em = $this->getDoctrine()->getManager();

        try {
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
            $user->setUserType($em->getRepository(UserType::class)->find(UserType::USER_TYPE_CLIENT));
            $this->getDoctrine()->getManager();


            $em->persist($user);

            $donor = new Donor();
            $donor->setOrgan($em->getRepository(OrganType::class)->find(1));
            $donor->setUser($user);

            $em->persist($donor);
            $em->flush();
        } 
        catch(UniqueConstraintViolationException $e){
         
            $response = [
                "success" => false,
                "message" => "the email has already been used",
                "data" => $data
            ];
            return $this->json($response, Response::HTTP_BAD_REQUEST);
        }
        catch (\Throwable $th) {

            $response = [
                "success" => false,
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
                "donor_id" => $donor->getId(),
            ]
        ];
        return $this->json($response, 200);
    }
    #[Route('/show', name: 'donor_show_api', methods: ['GET', 'POST'])]
    public function show(DonorRepository $donorRepository, Request $request)
    {


        try {

            $id = json_decode($request->getContent(), true)['id'];
            
                
            } catch (\Throwable $th) {
               
            }
        
            $response = [
                "success" => true,
                "message" => "fetched",
                "data" =>$donorRepository->getSingleData(["id"=>$id])
            ];
            return $this->json($response, 200);
    }
    #[Route('/', name: 'donor_index_api', methods: ['GET', 'POST'])]
    public function index(Request $request, DonorRepository $donorRepository)
    {

        $response = [
            "success" => true,
            "message" => "fetched",

            "data" => $donorRepository->getDonorsList()
        ];
        return $this->json($response, 200);
    }
}
