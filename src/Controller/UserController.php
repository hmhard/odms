<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index")
     */
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $userRepository->getData([]);
   

        $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('user/index.html.twig', [
            'users' => $data,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)
            ->add('userType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setCreatedAt(new \DateTime());
            $user->setCreatedAt(new \DateTime());

            $user->setRoles($request->request->get('user')['roles']);
           
            $password = $this->randomPassword();
            $user->setPassword($userPasswordEncoderInterface->encodePassword($user, $password));
            $user->setRegisteredBy($this->getUser());
            $user->setIsActive(true);
            $form_data = $request->request->get("user");
            $entityManager->persist($user);

    

            $entityManager->flush();
            $this->addFlash("success", "User Registered");
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/register", name="user_register", methods={"GET","POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user)
            ->add('roles', ChoiceType::class, ["choices" => ["Student" => "STUDENT"], 'mapped' => false, "required" => true, "multiple" => true, "placeholder" => "Select Role"])
            ->add('userType', null, [
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere("u.id=1");
                },
            ])
            ->add('idNumber',null,[
                "required"=>true,
                "mapped"=>false
            ])
            ->add('year',ChoiceType::class,["choices" =>
             ["1"=>1,
             "2"=>2,
             "3"=>3,
             "4"=>4,
             "5"=>5,
             "6"=>6,
             "7"=>7,
            ],
             
             "placeholder"=>"Select Year",
             "required"=>true,
             "mapped"=>false
             ])
            ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $user->setCreatedAt(new \DateTime());
            $user->setCreatedAt(new \DateTime());

            $user->setRoles($request->request->get('user')['roles']);
            $user->setUserName($this->get_username($user->getFirstName(), $user->getMiddleName()));

            $password = $this->randomPassword();
            $user->setPassword($userPasswordEncoderInterface->encodePassword($user, $password));
            $user->setRegisteredBy($this->getUser());
            $user->setIsActive(false);
            $form_data = $request->request->get("user");
            $entityManager->persist($user);

            if ($user->getUserType()->getId() == 1 && isset($form_data['idNumber']) && isset($form_data['year'])) {

                $student = new Student();
                $student->setUser($user);
                $student->setIdNumber($form_data['idNumber']);
                $student->setYear($form_data['year']);

                $entityManager->persist($student);
            }

            $entityManager->flush();
            $this->addFlash("success", "User Registered");
            return $this->render('user/show.success.html.twig', [
                'user' => $user,
                'password' => $password,
               
            ]);
        }

        return $this->render('user/register.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/activate", name="user_activate", methods={"GET","POST"})
     */
    public function activate(Request $request, User $user)
    {
      

        $user->setIsActive(true);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash("success", "User Account activated");
        return $this->redirectToRoute('user_show',["id"=>$user->getId()]);
       
      
    }
    /**
     * @Route("/{id}/deactivate", name="user_deactivate", methods={"GET","POST"})
     */
    public function deactivate(Request $request, User $user)
    {
      

        $user->setIsActive(false);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash("success", "User Account activated");
        return $this->redirectToRoute('user_show',["id"=>$user->getId()]);
       
      
    }
    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->get('roles')->setData($user->getRoles());
      
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($request->request->get('user')['roles']);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setIsDeleted(true);
            // $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash("success","moved to trash");
        }

        return $this->redirectToRoute('user_index');
    }

    function get_username($first, $middle)
    {
        $string_name = $first . " " . $middle;
        $rand_no = 10;
        $userRepository = $this->getDoctrine()->getManager()->getRepository(User::class);
        while (true) {
            $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
            $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
            $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, rand(4, 6)) : ""; //cut fi rs t  name to 8 letters
            $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, rand(3, 5)) : ""; //cut se co n d name to 5 letters
            $username = $part1 . $part2; //str _shuffle to randomly shuffle all characters 
            if (!$userRepository->findOneBy(['username' => $username]))
                break;
        }
        return $username;
    }

    static function randomPassword()
    {
        // return "1234";
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }
}
