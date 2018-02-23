<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 15/01/2018
 * Time: 13:48
 */

namespace AppBundle\Services;

use AppBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;

class Stripe {

    public function stripe(Ticket $ticket)
    {
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
            return true;
        }
        catch(\Stripe\Error\Card $e)
        {
            return false;
        }
    }
}