<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 01/12/2017
 * Time: 01:09
 */

namespace AppBundle\Services;

use AppBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;


class Session
{
    public function defineGetters(Request $request, Ticket $ticket)
    {
        $session= $request->getSession();
        $session->set('ticket',$ticket);

    }
}
