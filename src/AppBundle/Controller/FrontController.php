<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 20/11/2017
 * Time: 16:27
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketType;
use AppBundle\Services\CheckDate;
use AppBundle\Services\DefineBookingCode;
use AppBundle\Services\DefinePrice;
use AppBundle\Services\NbVisitors;
use AppBundle\Services\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Session;

class FrontController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function showHome()
    {
       return $this->render('home.html.twig');
    }

    /**
     * @Route("/booking", name="booking")
     */

    public function showBooking(Request $request, DefinePrice $definePrice, DefineBookingCode $code, NbVisitors $nbVisitors,
                                Session $session, CheckDate $checkDate)
    {

        $ticket= new Ticket();
        $formTicket= $this->createForm(TicketType::class, $ticket);

        $formTicket->handleRequest($request);

        if ($formTicket->isSubmitted()&& $formTicket->isValid())
        {
            $nbVisit=$nbVisitors->checkVisitors($ticket); //nbVisitors Service

            if($nbVisit==true)
            {
                $this->addFlash('error', 'complet');
               return $this->redirectToRoute('booking');
            }
            $ticket=$formTicket->getData();
           $date= $checkDate->checkDate($ticket); //CheckDate Service
           $hour= $checkDate->checkHour($ticket);
           $lastHour= $checkDate->checkLastHour($ticket);

            if($lastHour==true)
            {
                $this->addFlash('error', 'Vous ne pouvez pas réserver de billet pour le jour même après 17h00');
                return $this->redirectToRoute('booking');
            }
            elseif($date==true)
            {
                $this->addFlash('error', 'Fermé le mardi, le dimanche et les jours fériés');
                return $this->redirectToRoute('booking');
            }
            elseif($hour==true)
            {
                $this->addFlash('error', 'Vous ne pouvez pas réserver de billet "Journée" après 14h00');
                return $this->redirectToRoute('booking');
            }


            $definePrice->definePrice($ticket);  //DefinePrice Service
            $session->defineGetters($request, $ticket); //Session Service
            $code->defineCode($ticket); //DefineBookingCode Service
            $this->addFlash('success', 'formulaire enregistré');
            return $this->redirectToRoute('recap');
        }

        return $this->render('booking.html.twig', array('formTicket' => $formTicket->createView(),
            ));



    }

    /**
     * @Route("/recap", name="recap")
     */
    public function showRecap(Request $request)
    {
        $ticket=$request->getSession()->get('ticket');

        if ($ticket == null ){

            $this->addFlash('error', 'Vous n\'avez pas effectué de réservation');
            return $this->redirectToRoute('home');
        }

        return $this->render('recap.html.twig', array('ticket'=>$ticket) );
    }

    /**
     * @Route("/payment", name="payment")
     */

    public function payment(Request $request, Stripe $stripe)
    {
        $ticket=$request->getSession()->get('ticket');
        $payment=$stripe->stripe($ticket); //Stripe Service
        if($payment==true){
            $this->addFlash("success","Paiement accepté !");
            $em=$this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute("success");
        }
        else{
            $this->addFlash("error","Informations non valides");
            return $this->redirectToRoute("recap");
            // The card has been declined
        }


    }

    /**
     * @param Request $request
     * @Route("/success", name="success")
     */
    public function success(Request $request, \Swift_Mailer $mailer, Session $session)
    {
        $ticket=$request->getSession()->get('ticket');
        if ($ticket == null ){

            $this->addFlash('error', 'Vous n\'avez pas effectué de réservation');
            return $this->redirectToRoute('home');
        }
        $now= new \DateTime();
        $dateDay=$now->format('d/m/Y H:i:s');
        $message= (new \Swift_Message('Billetterie Louvre'))
        ->setFrom('arnaud.tortora@gmail.com')
        ->setTo($ticket->getEmail())
        ->setBody(
                $this->renderView('mail.html.twig', array('dateDay' => $dateDay, 'ticket'=> $ticket)),
                'text/html'
            );
        $mailer->send($message);

        $session->closeSession($request);

        return $this->render('success.html.twig');

    }

}