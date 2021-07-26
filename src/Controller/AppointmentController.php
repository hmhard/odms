<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;


#[Route('/appointment')]
class AppointmentController extends AbstractController
{
    #[Route('/', name: 'appointment_index', methods: ['GET'])]
    public function index(AppointmentRepository $appointmentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $appointmentRepository->getData([]);
   

        $data = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('appointment/index.html.twig', [
            'appointments' => $data,
        ]);
    }
    #[Route('/new', name: 'appointment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appointment);
            $entityManager->flush();
            if($appointment->getDonor()){
                $email = (new TemplatedEmail())
                ->from('mine@example.com')
                // ->to(new Address("miniye6453@gmail.com"))
                ->to(new Address($appointment->getDonor()->getUser()->getEmail()))
                ->cc(new Address($appointment->getAppointedBy()->getEmail()))
                ->subject('Appointment Notification!')
            
               ->htmlTemplate('emails/appointment.html.twig')
            
                ->context([
                    'appointment' =>$appointment,
                 
                ])
            ;
            try {
                $mailer->send($email); 
                $this->addFlash("success","appointment Email Sent to donor");
    
            } catch (\Throwable $th) {
              
            $this->addFlash("warning","Error on email sending");

            }
          
            }

            $this->addFlash("success","Appointment Created  Successfully");

            return $this->redirectToRoute('appointment_show', ["id"=>$appointment->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash("success","Updated Successfully");

            return $this->redirectToRoute('appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appointment);
            $entityManager->flush();
            $this->addFlash("success","Removed Successfully");

        }

        
        return $this->redirectToRoute('appointment_index', [], Response::HTTP_SEE_OTHER);
    }
}
