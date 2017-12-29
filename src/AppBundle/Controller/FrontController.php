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
            $em=$this->getDoctrine()->getManager();
            $nbVisit=$nbVisitors->checkVisitors($ticket);

            if($nbVisit==true)
            {
                $this->addFlash('error', 'complet');
               return $this->redirectToRoute('booking');
            }
            $ticket=$formTicket->getData();
           $date= $checkDate->checkDate($ticket);

            if($date==true)
            {
                $this->addFlash('error', 'Fermé le mardi et le dimanche et jours fériés');
                return $this->redirectToRoute('booking');
            }

            $definePrice->definePrice($ticket);
            $session->defineGetters($request, $ticket);
            $code->defineCode($ticket);

            $em->persist($ticket);
           // $em->flush();

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

        return $this->render('recap.html.twig', array('ticket'=>$ticket) );
    }

    /**
     * @Route("/payment", name="payment")
     */

    public function payment(Request $request)
    {
        $ticket=$request->getSession()->get('ticket');
        \Stripe\Stripe::setApiKey("sk_test_n3fxJsWsl0Wep28UiJnSvSrP");

        // Get the credit card details submitted by the form
        $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try
        {
            $charge = \Stripe\Charge::create(array(
                "amount" => ($ticket->getPrice()*100), // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Stripe",
            ));
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash("success","Bravo ça marche !");
            return $this->redirectToRoute("success");
        }
        catch(\Stripe\Error\Card $e)
        {
            $this->addFlash("error","Snif ça marche pas :(");
            return $this->redirectToRoute("recap");
            // The card has been declined
        }


    }

    /**
     * @param Request $request
     * @Route("/success", name="success")
     */
    public function success(Request $request, \Swift_Mailer $mailer)
    {
        $ticket=$request->getSession()->get('ticket');
        $now= new \DateTime();
        $dateDay=$now->format('d/m/Y H:i:s');
        $message= (new \Swift_Message('Hello Email'))
        ->setFrom('arnaud.tortora@gmail.com')
        ->setTo($ticket->getEmail())
        ->setBody(
                $this->renderView('mail.html.twig', array('dateDay' => $dateDay, 'ticket'=> $ticket)),
                'text/html'
            );
        $mailer->send($message);

        return $this->render('success.html.twig');

    }

}